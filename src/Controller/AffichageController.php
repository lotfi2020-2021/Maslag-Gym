<?php

namespace App\Controller;
use Twilio\Rest\Client;
use Mailjet\Client as c;
use Mailjet\Resources;
use App\Entity\Contact;
use App\Entity\Evenement;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use http\Message;
use phpDocumentor\Reflection\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
/**
 * @Route("/aff", name="aff")
 */
class AffichageController extends AbstractController
{
    /**
     * @Route("/affichage", name="affichage")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {


        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $donnees = $this->getDoctrine()->getRepository(evenement::class)->findAll();

        $evenement = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );


        return $this->render('affichage/index.html.twig', [
            'form' => $form->createView(),
            'evenement' => $evenement,
        ]);
    }
    /**
     * @return Serializer
     */
    protected function _getSerializer()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer           = new ObjectNormalizer($classMetadataFactory);

        return new Serializer([$normalizer], [new JsonEncoder()]);
    }

    /**
     * @Route("/search2", name="search2",methods={"POST"})
     */
    public function search(Request $request, PaginatorInterface $paginator): Response
    {
        $nom= $request->request->get('name');
        $donnees = $this->getDoctrine()->getRepository(evenement::class)->findByWord($nom);


        $array = [];
        foreach($donnees as $e){
            $object = (object) [
                'NomEvent' => $e->getNomEvent(),
                'id' => $e->getId(),
                'NumEvent' => $e->getNumEvent(),
                'DateEvent' => $e->getDateEvent()->format('Y-m-d'),
                'imageName' => $e->getImageName(),
                'AdresseEvent' => $e->getAdresseEvent(),
                'empty' =>"0"
            ];
            array_push($array,$object);
        }
        if(empty($array)) {
            $don = $this->getDoctrine()->getRepository(evenement::class)->findAll();
            foreach($don as $e){
                $object = (object) [
                    'NomEvent' => $e->getNomEvent(),
                    'id' => $e->getId(),
                    'NumEvent' => $e->getNumEvent(),
                    'DateEvent' => $e->getDateEvent()->format('Y-m-d'),
                    'imageName' => $e->getImageName(),
                    'AdresseEvent' => $e->getAdresseEvent(),
                    'empty' =>"1"
                ];
                array_push($array,$object);
            }
        }
        return new JsonResponse($array);





    }


    /**
     * @Route("/{id}", name="affichage_sh", methods={"GET"})
     */
    public function show(Evenement $evenement, Request $request): Response
    {

        return $this->render('affichage/details.html.twig', [
            'evenement' => $evenement,

        ]);
    }
    /**
     * @Route("/res/reservation", name="reservation", methods={"POST"})
     */
    public function reservation(Request $request,\Swift_Mailer $mailer): Response
    {
        $num= $request->request->get('numero');
        $email= $request->request->get('email');

        // Your Account SID and Auth Token from twilio.com/console
       // $sid = 'AC9d65ba74d474565cf6a4c6bdec3561b7';
        // $token = 'fef30113415f7eb9fd8892e24cb818eb';
        // $client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
        // $client->messages->create(
        // the number you'd like to send the message to

        //  $num,
        //  [
                // A Twilio phone number you purchased at twilio.com/console
        //      'from' => '+15737422155',

                // the body of the text message you'd like to send
        //      'body' => 'bonjour votre reservation est bien recus!'
        //  ]
        // );
        $user = $this->getUser();
        $mj = new C('9c07a6d8dbb570bfe09f3fafd7b1dcca', '2fd452e57e586b8805ff84bd956ac1a6',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mohamedmalek.saidi@esprit.tn",
                        'Name' => "une nouvelle reservation"
                    ],
                    'To' => [
                        [
                            'Email' => $user->getEmail(),
                            'Name' => ''
                            //'Name' => $user->getNom()
                        ]
                    ],

                    'Subject' => "une nouvelle reservation",
                    'TextPart' => "bonjour votre reservation est bien recus!"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && ($response->getData());

        $mj = new C('9c07a6d8dbb570bfe09f3fafd7b1dcca', '2fd452e57e586b8805ff84bd956ac1a6',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mohamedmalek.saidi@esprit.tn",
                        'Name' => "une nouvelle reservation"
                    ],
                    'To' => [
                        [
                            'Email' => "achref.benhadjyahia@esprit.tn",
                            'Name' => ''
                            //'Name' => $user->getNom()
                        ]
                    ],

                    'Subject' => "une nouvelle reservation",
                    'TextPart' => "une nouvelle reservation par utilisateur : ".$user->getEmail(),

                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && ($response->getData());








        return new Response("true");
    }


}

