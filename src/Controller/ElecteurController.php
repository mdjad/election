<?php

namespace App\Controller;

use App\Entity\Electeur;
use App\Form\ElecteurType;
use App\Repository\ElecteurRepository;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ElecteurController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('electeur/index.html.twig');
    }

    /**
     * @Route("/inscription/nouveau", name="inscription_new", methods={"GET","POST"})
     */
    public function inscription(Request $request ,Swift_Mailer $mailer): Response
    {
        $electeur = new Electeur();
        $form = $this->createForm(ElecteurType::class, $electeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = md5(random_bytes(10));
            $electeur->setToken($token);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($electeur);
            $entityManager->flush();

            //send mail admin
            $messageAdmin = (new Swift_Message())
                ->setSubject("Demande de Validation de ".$electeur)
                ->setFrom('noreplay@electiondiaspora.org')
                ->setTo("adresseDesAdministrateurQuiValide@exemple.fr")
                ->setBody($this->renderView( 'electeur/email/adminNotification.html.twig',
                    array('electeur' => $electeur ) ), 'text/html' );

            //send mail electeur
            $messageElect = (new Swift_Message())
                ->setSubject("Avis de reception a la liste électorale")
                ->setFrom('noreplay@electiondiaspora.org') //email admin
                ->setTo($electeur->getEmail())
                ->setBody($this->renderView( 'electeur/email/electeurNotification.html.twig',
                    array('electeur' => $electeur ) ), 'text/html' );


            $mailer->send($messageAdmin);
            $mailer->send($messageElect);

            $this->addFlash('success', 'Votre inscription a bien été effectué');
            return $this->redirectToRoute('home');
        }

        return $this->render('electeur/new.html.twig', [
            'electeur' => $electeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription/validation/{token}", name="electeur_redirect")
     */
    public function redirection($token, ElecteurRepository $electeurRepository): Response
    {
            $electeur =  $electeurRepository->findOneBy(array('token'=>$token));

            if($electeur) {
                return $this->redirectToRoute('easyadmin', array('action' => 'show','entity' => 'Electeur','menuIndex'=> 1,'id' => $electeur->getId()));
            }else{
                $this->addFlash('danger', 'Electeur non trouvé');
                return $this->redirectToRoute('easyadmin', array('action' => 'list','entity' => 'Electeur','menuIndex'=> 1 ));
            }
    }

    /**
     * @Route("/manager/electeur/validation", name="electeur_validation")
     * @IsGranted("ROLE_MANAGER")
     */
    public function validation(Request $request,Swift_Mailer $mailer, ElecteurRepository $electeurRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $electeur =  $electeurRepository->findOneBy($id);

        if(!$electeur) {
            $this->addFlash('danger', 'Electeur non trouvé !');
            return $this->redirectToRoute('easyadmin', array('action' => 'list', 'entity' => 'Electeur' ));
        }else{

            if($this->getUser()){
                if(! $electeur->getNumElectorale()) {
                    $electeur->setNumElectorale(self::generateNumerosElecteur($electeur));
                    $electeur->setValide(true);
                    $entityManager->persist($electeur);
                    $entityManager->flush();

                    //send mail electeur
                    $messageElect = (new Swift_Message())
                        ->setSubject("Numeros Electeur")
                        ->setFrom('noreplay@electiondiaspora.org') //email admin
                        ->setTo($electeur->getEmail())
                        ->setBody($this->renderView( 'electeur/email/electeurConfirmation.html.twig',
                            array('electeur' => $electeur ) ), 'text/html' );
                    $mailer->send($messageElect);

                    $this->addFlash('success', 'Validation effectué');
                }else{
                    $this->addFlash('warning', 'La demande a déjà été traiter');
                }
            }
            return $this->redirectToRoute('easyadmin', array('action' => 'show', 'entity' => 'Electeur', 'id' => $id));
        }
    }

    protected function generateNumerosElecteur(Electeur $electeur)
    {
        $date = $electeur->getDateNaissance()->format("Y");
        $likeCharacter = $electeur->getNom()[0];
        $newNumber = $likeCharacter . $date . '-' . str_pad($electeur->getId(), 4, '0', STR_PAD_LEFT);

        $serial = hash('md5',$electeur->getNumCarte());
        $formattedSerial = "";
        for($i=0; $i<strlen($serial)/2; $i++){
            if($i == 4 || $i == 8 || $i == 12 || $i == 16){
                $formattedSerial .= '-';
            }
            $formattedSerial .= $serial[$i];
        }

        $formattedSerial = $formattedSerial.'-'.$newNumber;
        $formattedSerial = strtoupper($formattedSerial);

        return $formattedSerial;

    }

}
