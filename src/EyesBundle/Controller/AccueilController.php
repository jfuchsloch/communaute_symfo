<?php

namespace EyesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EyesBundle\Entity\utilisateurs;
use EyesBundle\Entity\article;
use EyesBundle\Entity\message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;



class AccueilController extends Controller
{


 public function ReinitAction($id, Request $request)
    {
        //$MyActeur="coucou";
        //var_dump($MyActeur);

        // remmetre le boolean isConnected a 0 !!!
    
        
        //var_dump($id);
    

         $em=$this->getDoctrine()->getManager();

           $MyMembre=$em->getRepository("EyesBundle:utilisateurs")->findMembre_deconnexion($id);
          // var_dump($MyMembre);
            // var_dump($MyMembre);
             //$MyMembre= $em->getRepository("EyesBundle:utilisateurs")->updateMembre($id, $password);

            if (empty($MyMembre))
            {   //die("ko");
                throw $this->createNotFoundException("ce membre n'existe pas");
            }

         $em->getRepository("EyesBundle:utilisateurs")->updeconnexion($id);


       // die("kill");
        
         return $this->redirect($this->generateUrl("eyes_accueil"));


    }

public function geocalisationAction(Request $request)
{ 
     $MyMembre=[];
            $MyMembre[0]["login"]="";

        $adresse = "";

    var_dump("geocalisationAction");


    $form = $this->createFormBuilder()->add("adresse","text", ['label' => 'Tapez votre adresse:'])
            ->add("Localiser sur Google Map","submit")
            ->getForm();



    if ($request->isMethod("POST"))
    {

        
              // die("index");
              // $form->handleRequest($request);   
              $form->submit($request); 

              if ($form->isValid())
              {   
       
                
                  $adresse = $_POST['form']['adresse'];
                  return $this->render('EyesBundle:Accueil:index_geocalisation.html.twig',["formGeocalisation"=>$form->createView(),
                                                                           "membre"=>$MyMembre,
                                                                           "add"=>$adresse]);
  

            
              }

      }        

    return $this->render('EyesBundle:Accueil:index_geocalisation.html.twig',["formGeocalisation"=>$form->createView(),
                                                                           "membre"=>$MyMembre,
                                                                            "add"=>$adresse]);
  

}

public function emailAction(Request $request)
    {
        //$MyActeur="coucou";
        //var_dump($MyActeur);

        // remmetre le boolean isConnected a 0 !!!
    
        
        //var_dump($id);

       $form = $this->createFormBuilder()->add("destinataire", "text")
            ->add("objet","text")
            ->add("message","text")
            ->add("Envoyer","submit")
            ->getForm();


            $MyMembre=[];
            $MyMembre[0]["login"]="";

            if ($request->isMethod("POST"))
            {

              // die("index");
              // $form->handleRequest($request);   
              $form->submit($request); 

              if ($form->isValid())
              {   
                //die("valide1");
                //var_dump($_POST);

                $destinataire = $_POST['form']['destinataire'];
                $message = $_POST['form']['message'];
                $objet = $_POST['form']['objet'];

                $headers = "From: \"jean philippe\"<jfuchsloch@gmail.com>\n";
                $headers .= "Reply-To: jpfuchs@hotmail.com\n";
                $headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";

                if ($destinataire != "" && $message != "" && $objet != ""){

                    if(mail($destinataire,$objet,$message,$headers))
                    {
                          //var_dump( "L'email a bien ete envoye.");
                          $sessions = $request->getSession();

                          $sessions->getFlashBag()->add("sucess_email", "L'email a bien ete envoye");

                    }
                    else
                    {
                        //var_dump( "Une erreur c'est produite lors de l'envois de l'email.");
                         $sessions = $request->getSession();

                          $sessions->getFlashBag()->add("ko_email", "Une erreur c'est produite lors de l'envois de l'email");

                    }

                 }     

                //die("valide");
            }

          }

       
  
        //die("email");
        
         //return $this->redirect($this->generateUrl("eyes_accueil"));
        return $this->render('EyesBundle:Accueil:index_email.html.twig',["formEmail"=>$form->createView(),
                                                                           "membre"=>$MyMembre]);
  

    }



 public function indexAction($login,Request $request)
    {
        //$MyActeur="coucou";

        $Utilisateur = new utilisateurs();

  
        //$nouveauGenre->setType("essai");

        $form = $this->createFormBuilder($Utilisateur)->add("login", "text")
            ->add("password","text")
            ->add("Connectez-vous","submit")
            ->getForm();

        // $form->handleRequest($request);
        
    if ($request->isMethod("POST"))
    {

       // die("index");
      // $form->handleRequest($request);   
       $form->submit($request); 

        if ($form->isValid())
        {  
            //die("valide1");
            //var_dump($_POST);

              $id = $_POST['form']['login'];
              $password = $_POST['form']['password'];
            //$id = $form['login'];
            //$password = $form->modelData;

            //var_dump($id);
            //var_dump($password);

           // die("hahaha");

            $em= $this->getDoctrine()->getManager();
            $MyMembre= $em->getRepository("EyesBundle:utilisateurs")->findMembre($id, $password);
            //var_dump($MyMembre);
             //$MyMembre= $em->getRepository("EyesBundle:utilisateurs")->updateMembre($id, $password);

            if (empty($MyMembre))
            {   //die("ko");
                throw $this->createNotFoundException("ce membre n'existe pas");
            }

            //die("ok");
            $em->getRepository("EyesBundle:utilisateurs")->updateMembre($id, $password);


            $NbConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeMembreConnectes();
            
             $NbPersConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeConnectes();
           
            //var_dump($NbPersConnectes);
            //die('ok');
            //²die("validation en cours");
              $tab3=array();
            array_push($tab3, $NbPersConnectes);

            // $tab3bis = "<p>".$tab3."<span class='cust' >connectes</span> </p>";
                $tab3bis="";
                foreach ($tab3 as $key=>$value) 
                 {
                   $tab3bis = $tab3bis.$value;
                 }
                  $tab3bis = "<p>".$tab3bis."<span class='cust' > connectes</span> </p>";



              if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            $response = new JsonResponse();
            $response->setData( $tab3bis
                            );

            //var_dump($response);
            //die("ok");
       
             return $response;
        
        }

            

            return $this->render('EyesBundle:Accueil:index_accueil.html.twig',["formUtilisateurs"=>$form->createView(),
                                                                         "membre"=>$MyMembre,
                                                                         "MembreOnLine"=>$NbConnectes,
                                                                         "NbMembreOnLine"=>$NbPersConnectes]);
  

        }
        else{
        
       
            $validator = $this->get('validator');
            $errors = $validator->validate($Utilisateur);
            Foreach($errors as $e)
            {
            // echo $e->getMessage();
            }

             //die("test");
                $em= $this->getDoctrine()->getManager();
                $NbPersConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeConnectes();
         
                $tab3=array();
               // array_push($tab3,"<p>");
                array_push($tab3,$NbPersConnectes );
               // array_push($tab3, "<span class='cust' >connectes</span> </p>");

               
              //  $tab3bis = "<p>".$tab3."<span class='cust' >connectes</span> </p>";
                  $tab3bis="";
                foreach ($tab3 as $key=>$value) 
                 {
                   $tab3bis = $tab3bis.$value;
                 }
                  $tab3bis = "<p>".$tab3bis."<span class='cust' > connectes</span> </p>";


              if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
                 $response = new JsonResponse();
                 $response->setData( $tab3bis
                            );

                //var_dump($response);
                //die("ok");
       
                 return $response;
        
              }



        }

      } // fin POST

      else{  //requet GET
       // die("index2");
        // Recupere le nombre de connectes pour la requete AJAX
        $em= $this->getDoctrine()->getManager();
        $NbConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeMembreConnectes();
     
         $NbPersConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeConnectes();
         $tab3=array();
         array_push($tab3, "<p>test</p>");


       $tab1=array();
     
       // Convertit le tableau d'objet en tableau associatif pour le setData
       foreach ($NbConnectes as $Connectes) 
       {
                //var_dump($Connectes->getLogin());
                array_push($tab1, $Connectes->getLogin());
        }
        
        $tab2 = "<p>Membre en ligne</p><ul>";
        foreach ($tab1 as $key=>$value) 
       {
            $tab2 = $tab2."<li>".$value."</li>";
       }        
       $tab2=$tab2."</ul>";

        //die("ko");

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            $response = new JsonResponse();
            $response->setData(  $tab2
                            );

            //var_dump($response);
            //die("ok");
       
             return $response;
        
        }

          // tester ici si le parametre login passe a index existe-> oui  juste si appele
          // depuis acceuil de services, conso, etc
       
      // var_dump($login);

          $em= $this->getDoctrine()->getManager();
          $MyMembre= $em->getRepository("EyesBundle:utilisateurs")->findMembre_serv($login);
           // var_dump($MyMembre);
             //$MyMembre= $em->getRepository("EyesBundle:utilisateurs")->updateMembre($id, $password);

          
          /*if (empty($MyMembre))
            {   //die("ko");
                throw $this->createNotFoundException("ce membre n'existe pas");
            }*/

      
        if ($login == "")
        {
          $MyMembre=[];
          $MyMembre[0]["login"]="";
        }
        // var_dump($MyMembre);

        return $this->render('EyesBundle:Accueil:index_accueil.html.twig',[ "formUtilisateurs"=>$form->createView(), 
                                                                            "membre"=>$MyMembre,
                                                                            "MembreOnLine"=>$NbConnectes,
                                                                            "NbMembreOnLine"=>$NbPersConnectes]);
      
        //return $this->render('EyesBundle:Accueil:index_accueil.html.twig',["formUtilisateurs"=>$form->createView()]);
     
      }

    }


public function indexEnglishAction($login, Request $request)
    {
        //$MyActeur="coucou";

        $Utilisateur = new utilisateurs();

  
        //$nouveauGenre->setType("essai");

        //return $this->render('EyesBundle:Accueil:index_accueil.html.twig',["formUtilisateurs"=>$form->createView()]);
        $form = $this->createFormBuilder($Utilisateur)->add("login", "text")
            ->add("password","text")
            ->add("Connection","submit")
            ->getForm();

        // $form->handleRequest($request);
        
    if ($request->isMethod("POST"))
    {

       // die("index");
      // $form->handleRequest($request);   
       $form->submit($request); 

        if ($form->isValid())
        {  
            //die("valide1");
            //var_dump($_POST);

              $id = $_POST['form']['login'];
              $password = $_POST['form']['password'];
            //$id = $form['login'];
            //$password = $form->modelData;

            //var_dump($id);
            //var_dump($password);

           // die("hahaha");

            $em= $this->getDoctrine()->getManager();
            $MyMembre= $em->getRepository("EyesBundle:utilisateurs")->findMembre($id, $password);
            //var_dump($MyMembre);
             //$MyMembre= $em->getRepository("EyesBundle:utilisateurs")->updateMembre($id, $password);

            if (empty($MyMembre))
            {   //die("ko");
                throw $this->createNotFoundException("member doesn't exist");
            }

            //die("ok");
            $em->getRepository("EyesBundle:utilisateurs")->updateMembre($id, $password);


            $NbConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeMembreConnectes();
            
             $NbPersConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeConnectes();
           
            //var_dump($NbPersConnectes);
            //die('ok');
            //²die("validation en cours");
              $tab3=array();
            array_push($tab3, $NbPersConnectes);

            // $tab3bis = "<p>".$tab3."<span class='cust' >connectes</span> </p>";
                $tab3bis="";
                foreach ($tab3 as $key=>$value) 
                 {
                   $tab3bis = $tab3bis.$value;
                 }
                  $tab3bis = "<p>".$tab3bis."<span class='cust' > connected</span> </p>";



              if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            $response = new JsonResponse();
            $response->setData( $tab3bis
                            );

            //var_dump($response);
            //die("ok");
       
             return $response;
        
        }

            

            return $this->render('EyesBundle:Accueil:index_accueil_english.html.twig',["formUtilisateurs"=>$form->createView(),
                                                                         "membre"=>$MyMembre,
                                                                         "MembreOnLine"=>$NbConnectes,
                                                                         "NbMembreOnLine"=>$NbPersConnectes]);
  

        }
        else{
        
       
            $validator = $this->get('validator');
            $errors = $validator->validate($Utilisateur);
            Foreach($errors as $e)
            {
            // echo $e->getMessage();
            }

             //die("test");
                $em= $this->getDoctrine()->getManager();
                $NbPersConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeConnectes();
         
                $tab3=array();
               // array_push($tab3,"<p>");
                array_push($tab3,$NbPersConnectes );
               // array_push($tab3, "<span class='cust' >connectes</span> </p>");

               
              //  $tab3bis = "<p>".$tab3."<span class='cust' >connectes</span> </p>";
                  $tab3bis="";
                foreach ($tab3 as $key=>$value) 
                 {
                   $tab3bis = $tab3bis.$value;
                 }
                  $tab3bis = "<p>".$tab3bis."<span class='cust' > connected</span> </p>";


              if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
                 $response = new JsonResponse();
                 $response->setData( $tab3bis
                            );

                //var_dump($response);
                //die("ok");
       
                 return $response;
        
              }



        }

      } // fin POST

      else{  //requet GET
       // die("index2");
        // Recupere le nombre de connectes pour la requete AJAX
        $em= $this->getDoctrine()->getManager();
        $NbConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeMembreConnectes();
     
         $NbPersConnectes = $em->getRepository("EyesBundle:utilisateurs")->getNombreDeConnectes();
         $tab3=array();
         array_push($tab3, "<p>test</p>");


       $tab1=array();
     
       // Convertit le tableau d'objet en tableau associatif pour le setData
       foreach ($NbConnectes as $Connectes) 
       {
                //var_dump($Connectes->getLogin());
                array_push($tab1, $Connectes->getLogin());
        }
        
        $tab2 = "<p>Members on line</p><ul>";
        foreach ($tab1 as $key=>$value) 
       {
            $tab2 = $tab2."<li>".$value."</li>";
       }        
       $tab2=$tab2."</ul>";

        //die("ko");

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            $response = new JsonResponse();
            $response->setData(  $tab2
                            );

            //var_dump($response);
            //die("ok");
       
             return $response;
        
        }

          // tester ici si le parametre login passe a index existe-> oui  juste si appele
          // depuis acceuil de services, conso, etc
       
      // var_dump($login);

          $em= $this->getDoctrine()->getManager();
          $MyMembre= $em->getRepository("EyesBundle:utilisateurs")->findMembre_serv($login);
           // var_dump($MyMembre);
             //$MyMembre= $em->getRepository("EyesBundle:utilisateurs")->updateMembre($id, $password);

          
          /*if (empty($MyMembre))
            {   //die("ko");
                throw $this->createNotFoundException("ce membre n'existe pas");
            }*/

      
        if ($login == "")
        {
          $MyMembre=[];
          $MyMembre[0]["login"]="";
        }
        // var_dump($MyMembre);

        return $this->render('EyesBundle:Accueil:index_accueil_english.html.twig',[ "formUtilisateurs"=>$form->createView(), 
                                                                            "membre"=>$MyMembre,
                                                                            "MembreOnLine"=>$NbConnectes,
                                                                            "NbMembreOnLine"=>$NbPersConnectes]);
      
        //return $this->render('EyesBundle:Accueil:index_accueil.html.twig',["formUtilisateurs"=>$form->createView()]);
     
      }

      
    }

  
    public function CreationAction(Request $request)
    {

         $nouveauMembre = new utilisateurs();
    

          $form = $this->createFormBuilder($nouveauMembre,array(
    'validation_groups' => array('registration')))->add('age', 'choice', array(
                'choices'   => array('0-18ans' => '0-18ans', '18-98ans' => '18-98ans'),
                'expanded'  => false,
            ))->add('pays', 'choice', array(
                'choices'   => array('france' => 'France', 'espagne' => 'Espagne'),
                'expanded'  => false,
            ))->add("region","text")
            ->add("ville","text")
            ->add("codepostal","text")
            ->add("email", "text")
            ->add("login","text")
            ->add("password","text")
            ->add("valider","submit")
            ->getForm();
        

        //if ($request->isMethod("POST"))
        // {   //var_dump($nouveauGenre);
        // $form->submit($request);
        //die(var_dump($nouveauGenre));

        //   if ($form->isValid())
        // {
       //die("post");

        $form->handleRequest($request);
        if ($form->isValid())
        {
           //var_dump("je rentre dans la creeation et je suis valide");
            $em = $this->getDoctrine()->getManager(); //on surveille l'objet
 
            //encodage mot de  passe
            $pwd_encode = sha1($nouveauMembre->getpassword());

            $nouveauMembre->setpassword($pwd_encode);
           
            $em->persist($nouveauMembre);
            

            $em->flush(); // on registre l'objet


            $sessions = $request->getSession();

            $sessions->getFlashBag()->add("sucess_membre", "Vous etes bien enregistré comme nouveau membre, veuillez vous reconnecter avec vos nouveaux identifiants");



            return $this->redirect($this->generateUrl("eyes_accueil"));
        }


      
    
        $MyMembre=[];
        $MyMembre[0]["login"]="";
     
        return $this->render('EyesBundle:Creation:creation_membre.html.twig',["formUtilisateurs"=>$form->createView(), "membre"=>$MyMembre]);
    }
    
    



public function CreationEnglishAction(Request $request)
    {

         $nouveauMembre = new utilisateurs();
    

          $form = $this->createFormBuilder($nouveauMembre,array(
    'validation_groups' => array('registration')))->add('age', 'choice', array(
                'choices'   => array('0-18ans' => '0-18ans', '18-98ans' => '18-98ans'),
                'expanded'  => false,
            ))->add("pays",'choice', array(
                'choices'   => array('france' => 'France', 'espagne' => 'Spain'),
                'expanded'  => false
            ))->add("region","text", ['label' => 'Area'])
            ->add("ville","text",['label' => 'City'])
            ->add("codepostal","text",['label' => 'Zip code'])
             ->add("email", "text",['label' => 'Mail'])
            ->add("login","text")
            ->add("password","text")
            ->add("Submit","submit")
            ->getForm();
        

        //if ($request->isMethod("POST"))
        // {   //var_dump($nouveauGenre);
        // $form->submit($request);
        //die(var_dump($nouveauGenre));

        //   if ($form->isValid())
        // {
       //die("post");

        $form->handleRequest($request);
        if ($form->isValid())
        {
           
            $em = $this->getDoctrine()->getManager(); //on surveille l'objet
 
            //encodage mot de  passe
            $pwd_encode = sha1($nouveauMembre->getpassword());

            $nouveauMembre->setpassword($pwd_encode);
           
            $em->persist($nouveauMembre);
            

            $em->flush(); // on registre l'objet


            $sessions = $request->getSession();

            $sessions->getFlashBag()->add("sucess_membre", "Vous etes bien enregistré comme nouveau membre, veuillez vous reconnecter avec vos nouveaux identifiants");



            return $this->redirect($this->generateUrl("eyes_accueil_english"));
        }


      
    
        $MyMembre=[];
        $MyMembre[0]["login"]="";
     
        return $this->render('EyesBundle:Creation:creation_membre_english.html.twig',["formUtilisateurs"=>$form->createView(), "membre"=>$MyMembre]);
    }
    

  

    public function chatAction($login, Request $request)
    {
        
         $nouveauArticle = new article();

          $form = $this->createFormBuilder($nouveauArticle)->add("pseudo","text")
            ->add("email","text")
            ->add("nom","text",['label' => 'Nom produit'])
            ->add("description","textarea",['label' => 'Description'])
            ->add("prix","integer")
            ->add("image", "file",['label' => 'Photo'])
            ->add("valider","submit")
            ->getForm();

            //Recuperation des articles
            $em= $this->getDoctrine()->getManager(); //Recuperation de doctrine em = entity manager
            $tousLesArticles = $em->getRepository("EyesBundle:Article")->findAll();
            
            //Recuperation des messages
            //$em= $this->getDoctrine()->getManager(); //Recuperation de doctrine em = entity manager
            $em= $this->getDoctrine()->getManager(); //Recuperation de doctrine em = entity manager
            
            $tousLesMessages = $em->getRepository("EyesBundle:message")->findAll();

            //var_dump($tousLeMessages);

             //Recuperation du panier article
            $em= $this->getDoctrine()->getManager(); //Recuperation de doctrine em = entity manager
            $pannierArticles = $em->getRepository("EyesBundle:pannierarticle")->findAll();
            //var_dump($pannierArticles);
            //die("ok");
           

            $encoders = array(new JsonEncoder());
          $normalizers = array(new GetSetMethodNormalizer());

          $serializer = new Serializer($normalizers, $encoders);

          $tousLesArticles = $serializer->serialize($tousLesArticles, 'json');
          $pannierArticles = $serializer->serialize($pannierArticles, 'json');
          //var_dump($pannierArticles);

          //die("ok");
           

          // Post formulaire message forum
          if ( !empty($_POST['valider']) == true )
          {        
              //var_dump("form post 2");
          
              $nouveauMessage = new message();

           
              $auteur = $_POST['inputAuteur']; 
              $contenu = $_POST['inputContenu'];

              $date_message = date ("Y-m-d H:i:s");

              $nouveauMessage->setAuteur($auteur);
              $nouveauMessage->setContenu($contenu);
              $nouveauMessage->setDate_message($date_message);

              $em = $this->getDoctrine()->getManager(); //on surveille l'objet


              $em->persist($nouveauMessage);
                //$nouveauGenre->setType("toto");

              $em->flush(); // on registre l'objet

              $em= $this->getDoctrine()->getManager(); //Recuperation de doctrine em = entity manager
              $tousLesMessages = $em->getRepository("EyesBundle:message")->findAll();
           

              $MyMembre=[];
              $MyMembre[0]["login"]=$login;
           
              return $this->render('EyesBundle:Chat:chat_membre.html.twig',["formArticle"=>$form->createView(),
                                                                              "membre"=>$MyMembre,
                                                                              "allArticles"=>$tousLesArticles,
                                                                              "allMessages"=>$tousLesMessages,
                                                                              "pannier"=>$pannierArticles]);
         }
         else{
            //var_dump("debut");
            //die("ko");
          //var_dump($tousLesArticles);


            $form->handleRequest($request);
            
            //Post formulaire article
            if ($form->isValid())
           {
                //var_dump("form1 post ok");
                //var_dump($nouveauArticle);
                $em = $this->getDoctrine()->getManager(); //on surveille l'objet

                $nouveauArticle->upload();


                $em->persist($nouveauArticle);
                //$nouveauGenre->setType("toto");

                $em->flush(); // on registre l'objet


                // $sessions = $request->getSession();
                //die("ok");
                //$sessions->getFlashBag()->add("sucess_article", "L'article a bien été ajouté");

                 $sessions = $request->getSession();

                $sessions->getFlashBag()->add("sucess_article", "L'article a bien été ajouté");


                $em= $this->getDoctrine()->getManager(); //Recuperation de doctrine em = entity manager
                $tousLesArticles = $em->getRepository("EyesBundle:Article")->findAll();

                  $encoders = array(new JsonEncoder());
          $normalizers = array(new GetSetMethodNormalizer());

          $serializer = new Serializer($normalizers, $encoders);

          $tousLesArticles = $serializer->serialize($tousLesArticles, 'json');
          
           

                $MyMembre=[];
                $MyMembre[0]["login"]=$login;
           

                return $this->render('EyesBundle:Chat:chat_membre.html.twig',["formArticle"=>$form->createView(),
                                                                              "membre"=>$MyMembre,
                                                                              "allArticles"=>$tousLesArticles,
                                                                              "allMessages"=>$tousLesMessages,
                                                                              "pannier"=>$pannierArticles]);
              }
              else{
                $validator = $this->get('validator');
                $errors = $validator->validate($nouveauArticle);
                Foreach($errors as $e)
                {
                  echo $e->getMessage();
                }
              }

            
              $MyMembre=[];
              $MyMembre[0]["login"]=$login;
           
              return $this->render('EyesBundle:Chat:chat_membre.html.twig',["formArticle"=>$form->createView(),
                                                                              "membre"=>$MyMembre,
                                                                              "allArticles"=>$tousLesArticles,
                                                                              "allMessages"=>$tousLesMessages,
                                                                              "pannier"=>$pannierArticles]);

            }
             
   }
    
    public function servicesAction($login, Request $request)
    {

         $nouveauMembre = new utilisateurs();
    

          $form = $this->createFormBuilder($nouveauMembre,array(
    'validation_groups' => array('registrationbis')))->add('age', 'choice', array(
                'choices'   => array('0-18ans' => '0-18ans', '18-98ans' => '18-98ans'),
                'expanded'  => false,
            ))->add('pays', 'choice', array(
                'choices'   => array('france' => 'France', 'espagne' => 'Espagne'),
                'expanded'  => false,
            ))->add("region","text")
            ->add("ville","text")
            ->add("rechercher","submit")
            ->getForm();
        

        //if ($request->isMethod("POST"))
        // {   //var_dump($nouveauGenre);
        // $form->submit($request);
        //die(var_dump($nouveauGenre));

        //   if ($form->isValid())
        // {
       //die("post");

      

        $form->handleRequest($request);
        if ($form->isValid())
        {
           //var_dump("je rentre dans la creeation et je suis valide");
            $em = $this->getDoctrine()->getManager(); //on surveille l'objet

            $age = $nouveauMembre->getAge();
            $pays = $nouveauMembre->getPays();
            $ville = $nouveauMembre->getVille();
            $region = $nouveauMembre->getRegion();
 
           $MyMembre_services= $em->getRepository("EyesBundle:utilisateurs")->findMembre_Services($age, $pays,$ville,$region);
            //var_dump($MyMembre);

            //die("ok");

            $MyMembre=[];
             $MyMembre[0]["login"]=$login;
            

             //var_dump($MyMembre);

             //die("ok");
     

            return $this->render('EyesBundle:Services:services_membre_1.html.twig',[ "membre_services"=>$MyMembre_services, 
                                                                                      "membre"=>$MyMembre
                                                                                      ]);
  
            //return $this->redirect($this->generateUrl("eyes_accueil"));
        }
         else{
        
       
            $validator = $this->get('validator');
            $errors = $validator->validate($nouveauMembre);
            Foreach($errors as $e)
            {
             echo $e->getMessage();
            }

            // die("test");

        }

    
        $MyMembre=[];
         $MyMembre[0]["login"]=$login;
        

         // var_dump($MyMembre);

        //die("ok");
     
     
        return $this->render('EyesBundle:Services:services_membre.html.twig',["formUtilisateurs"=>$form->createView(), "membre"=>$MyMembre]);
    }
    

 
    public function services_englishAction($login, Request $request)
    {

         $nouveauMembre = new utilisateurs();
    

          $form = $this->createFormBuilder($nouveauMembre,array(
    'validation_groups' => array('registrationbis')))->add('age', 'choice', array(
                'choices'   => array('0-18ans' => '0-18ans', '18-98ans' => '18-98ans'),
                'expanded'  => false,
            ))->add('pays', 'choice', array(
                'choices'   => array('france' => 'France', 'spain' => 'Spain'),
                'expanded'  => false,
            ))->add("region","text",['label' => 'area'])
            ->add("ville","text",['label' => 'city'])
            ->add("search","submit")
            ->getForm();
        

        //if ($request->isMethod("POST"))
        // {   //var_dump($nouveauGenre);
        // $form->submit($request);
        //die(var_dump($nouveauGenre));

        //   if ($form->isValid())
        // {
       //die("post");

        $form->handleRequest($request);
        if ($form->isValid())
        {
           //var_dump("je rentre dans la creeation et je suis valide");
            $em = $this->getDoctrine()->getManager(); //on surveille l'objet

            $age = $nouveauMembre->getAge();
            $pays = $nouveauMembre->getPays();
            $ville = $nouveauMembre->getVille();
            $region = $nouveauMembre->getRegion();
 
           $MyMembre_services= $em->getRepository("EyesBundle:utilisateurs")->findMembre_Services($age, $pays,$ville,$region);
            //var_dump($MyMembre);

            //die("ok");

            $MyMembre=[];
             $MyMembre[0]["login"]=$login;
            

             //var_dump($MyMembre);

             //die("ok");
     

            return $this->render('EyesBundle:Services:services_membre_1_english.html.twig',[ "membre_services"=>$MyMembre_services, "membre"=>$MyMembre]);
  
            //return $this->redirect($this->generateUrl("eyes_accueil"));
        }
         else{
        
       
            $validator = $this->get('validator');
            $errors = $validator->validate($nouveauMembre);
            Foreach($errors as $e)
            {
             echo $e->getMessage();
            }

            // die("test");

        }

    
        $MyMembre=[];
         $MyMembre[0]["login"]=$login;
        

         // var_dump($MyMembre);

        //die("ok");
     
     
        return $this->render('EyesBundle:Services:services_membre_english.html.twig',["formUtilisateurs"=>$form->createView(), "membre"=>$MyMembre]);
    }


 public function loisirsAction($login, Request $request)
    {

         $nouveauMembre = new utilisateurs();
    

          $form = $this->createFormBuilder($nouveauMembre,array(
    'validation_groups' => array('registrationbis')))->add('age', 'choice', array(
                'choices'   => array('0-18ans' => '0-18ans', '18-98ans' => '18-98ans'),
                'expanded'  => false,
            ))->add('pays', 'choice', array(
                'choices'   => array('france' => 'France', 'espagne' => 'Espagne'),
                'expanded'  => false,
            ))->add("region","text")
            ->add("ville","text")
            ->add("rechercher","submit")
            ->getForm();
        

        //if ($request->isMethod("POST"))
        // {   //var_dump($nouveauGenre);
        // $form->submit($request);
        //die(var_dump($nouveauGenre));

        //   if ($form->isValid())
        // {
       //die("post");

        $form->handleRequest($request);
        if ($form->isValid())
        {
           //var_dump("je rentre dans la creeation et je suis valide");
            $em = $this->getDoctrine()->getManager(); //on surveille l'objet

            $age = $nouveauMembre->getAge();
            $pays = $nouveauMembre->getPays();
            $ville = $nouveauMembre->getVille();
            $region = $nouveauMembre->getRegion();
 
           $MyMembre_services= $em->getRepository("EyesBundle:utilisateurs")->findMembre_Services($age, $pays,$ville,$region);
            //var_dump($MyMembre);

            //die("ok");

            $MyMembre=[];
             $MyMembre[0]["login"]=$login;
            

             //var_dump($MyMembre);

             //die("ok");
     

            return $this->render('EyesBundle:Loisirs:loisirs_membre_1.html.twig',[ "membre_services"=>$MyMembre_services, "membre"=>$MyMembre]);
  
            //return $this->redirect($this->generateUrl("eyes_accueil"));
        }
         else{
        
       
            $validator = $this->get('validator');
            $errors = $validator->validate($nouveauMembre);
            Foreach($errors as $e)
            {
             echo $e->getMessage();
            }

            // die("test");

        }

    
        $MyMembre=[];
         $MyMembre[0]["login"]=$login;
        

         // var_dump($MyMembre);

        //die("ok");
     
     
        return $this->render('EyesBundle:Loisirs:loisirs_membre.html.twig',["formUtilisateurs"=>$form->createView(), "membre"=>$MyMembre]);
    }

    
    public function cultureAction($login, Request $request)
    {

         $nouveauMembre = new utilisateurs();
    

          $form = $this->createFormBuilder($nouveauMembre,array(
    'validation_groups' => array('registrationbis')))->add('age', 'choice', array(
                'choices'   => array('0-18ans' => '0-18ans', '18-98ans' => '18-98ans'),
                'expanded'  => false,
            ))->add('pays', 'choice', array(
                'choices'   => array('france' => 'France', 'espagne' => 'Espagne'),
                'expanded'  => false,
            ))->add("region","text")
            ->add("ville","text")
            ->add("rechercher","submit")
            ->getForm();
        

        //if ($request->isMethod("POST"))
        // {   //var_dump($nouveauGenre);
        // $form->submit($request);
        //die(var_dump($nouveauGenre));

        //   if ($form->isValid())
        // {
       //die("post");

        $form->handleRequest($request);
        if ($form->isValid())
        {
           //var_dump("je rentre dans la creeation et je suis valide");
            $em = $this->getDoctrine()->getManager(); //on surveille l'objet

            $age = $nouveauMembre->getAge();
            $pays = $nouveauMembre->getPays();
            $ville = $nouveauMembre->getVille();
            $region = $nouveauMembre->getRegion();
 
           $MyMembre_services= $em->getRepository("EyesBundle:utilisateurs")->findMembre_Services($age, $pays,$ville,$region);
            //var_dump($MyMembre);

            //die("ok");

            $MyMembre=[];
             $MyMembre[0]["login"]=$login;
            

             //var_dump($MyMembre);

             //die("ok");
     

            return $this->render('EyesBundle:Culture:culture_membre_1.html.twig',[ "membre_services"=>$MyMembre_services, "membre"=>$MyMembre]);
  
            //return $this->redirect($this->generateUrl("eyes_accueil"));
        }
         else{
        
       
            $validator = $this->get('validator');
            $errors = $validator->validate($nouveauMembre);
            Foreach($errors as $e)
            {
             echo $e->getMessage();
            }

            // die("test");

        }

    
        $MyMembre=[];
         $MyMembre[0]["login"]=$login;
        

         // var_dump($MyMembre);

        //die("ok");
     
     
        return $this->render('EyesBundle:Culture:culture_membre.html.twig',["formUtilisateurs"=>$form->createView(), "membre"=>$MyMembre]);
    }

  
     public function consoAction($login, Request $request)
    {

         $nouveauMembre = new utilisateurs();
    

          $form = $this->createFormBuilder($nouveauMembre,array(
    'validation_groups' => array('registrationbis')))->add('age', 'choice', array(
                'choices'   => array('0-18ans' => '0-18ans', '18-98ans' => '18-98ans'),
                'expanded'  => false,
            ))->add('pays', 'choice', array(
                'choices'   => array('france' => 'France', 'espagne' => 'Espagne'),
                'expanded'  => false,
            ))->add("region","text")
            ->add("ville","text")
            ->add("rechercher","submit")
            ->getForm();
        

        //if ($request->isMethod("POST"))
        // {   //var_dump($nouveauGenre);
        // $form->submit($request);
        //die(var_dump($nouveauGenre));

        //   if ($form->isValid())
        // {
       //die("post");

        $form->handleRequest($request);
        if ($form->isValid())
        {
           //var_dump("je rentre dans la creeation et je suis valide");
            $em = $this->getDoctrine()->getManager(); //on surveille l'objet

            $age = $nouveauMembre->getAge();
            $pays = $nouveauMembre->getPays();
            $ville = $nouveauMembre->getVille();
            $region = $nouveauMembre->getRegion();
 
           $MyMembre_services= $em->getRepository("EyesBundle:utilisateurs")->findMembre_Services($age, $pays,$ville,$region);
            //var_dump($MyMembre);

            //die("ok");

            $MyMembre=[];
             $MyMembre[0]["login"]=$login;
            

             //var_dump($MyMembre);

             //die("ok");
     

            return $this->render('EyesBundle:Conso:conso_membre_1.html.twig',[ "membre_services"=>$MyMembre_services, "membre"=>$MyMembre]);
  
            //return $this->redirect($this->generateUrl("eyes_accueil"));
        }
         else{
        
       
            $validator = $this->get('validator');
            $errors = $validator->validate($nouveauMembre);
            Foreach($errors as $e)
            {
             echo $e->getMessage();
            }

            // die("test");

        }

    
        $MyMembre=[];
         $MyMembre[0]["login"]=$login;
        

         // var_dump($MyMembre);

        //die("ok");
     
     
        return $this->render('EyesBundle:Conso:conso_membre.html.twig',["formUtilisateurs"=>$form->createView(), "membre"=>$MyMembre]);
    }
 
    
}

