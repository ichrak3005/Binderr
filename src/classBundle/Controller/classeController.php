<?php

namespace classBundle\Controller;

use CalendrierMedecinsBundle\Entity\Patient;
use CalendrierMedecinsBundle\Form\searchType;
use classBundle\Entity\classe;
use classBundle\Entity\timetable;
use classBundle\Entity\Ttable;
use classBundle\Entity\Ttime;
use classBundle\Form\addTimeTableType;
use classBundle\Form\classeType;
use classBundle\Form\createTimeTableType;
use classBundle\Form\readTtimeType;
use classBundle\Form\searchTimeTableType;
use classBundle\Form\searchTtime;
use classBundle\Form\updateTimeTableType;
use classBundle\Form\updateType;
use classBundle\Repository\TtimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class classeController extends Controller
{
    public function addAction(Request $request)
    {   //create an object to store our data after the form submission
        $class=new classe();
        //prepare the form with the function: createForm()
        $form=$this->createForm(classeType::class,$class);
        //extract the form answer from the received request
        $form=$form->handleRequest($request);
        //if this form is valid
        if($form->isValid()){
            //create an entity manager object
            $em=$this->getDoctrine()->getManager();
            //persist the object $club in the ORM
            $em->persist($class);
            //update the data base with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('class_add');
        }
        return $this->render('@class/Default/add.html.twig', array(
            'form'=>$form->createView()
        ));
    }
    public function readAction()
    {
        // return $this->render('@Club/Default/read.html.twig');
        //Fetching Objects (Clubs) from the Database
        $class=$this->getDoctrine()->getManager()->getRepository(classe::class)->findAll();

        //add the list of clubs to the render function as input to be sent to the view
        return $this->render('@class/Default/read.html.twig', array('classe'=>$class ));

    }
    public function deleteAction($id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $class= $em->getRepository(classe::class)->find($id);
        //remove from the ORM
        $em->remove($class);
        //update the data base
        $em->flush();
        return $this->redirectToRoute("class_read");
    }


    public function updateAction(Request $request, $id)
    {
        $class= $this->getDoctrine()->getmanager()->getRepository(classe::class)->find($id);
        $form= $this->createForm(updateType::class,$class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $ef= $this->getDoctrine()->getManager();
            $ef->persist($class);
            $ef->flush();
            return $this->redirectToRoute("class_read");
        }
        return $this->render("@class/Default/update.html.twig",array("form"=>$form->createView()));

    }

/*

    public function addTimeTableAction(Request $request)
    {
        $timeTable=new timetable();
        //prepare the form with the function: createForm()
        $form=$this->createForm(addTimeTableType::class,$timeTable);
        //extract the form answer from the received request
        $form=$form->handleRequest($request);
        //if this form is valid
        if($form->isValid()){
            //create an entity manager object
            $em=$this->getDoctrine()->getManager();
            //persist the object $club in the ORM
            $em->persist($timeTable);
            //update the data base with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('class_addTimeTable');
        }
        return $this->render('@class/Default/addTimeTable.html.twig', array(
            'form'=>$form->createView()
        ));



            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded


    }*/
    public function addTimeTableAction(Request $request)
    {
        $timeTable=new timetable();
        $form=$this->createForm(addTimeTableType::class,$timeTable);
        $form=$form->handleRequest($request);


        if($form->isValid()&& $form->isSubmitted()){
            /**
             * @var UploadedFile $file
             */
            $file=$timeTable->getContent();
            $fileName= uniqid().'.'.$file->getExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $timeTable->setContent($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($timeTable);

            $em->flush();
            return $this->redirectToRoute('class_addTimeTable');
        }
        return $this->render('@class/Default/addTimeTable.html.twig', array(
            'form'=>$form->createView()
        ));



        // this condition is needed because the 'brochure' field is not required
        // so the PDF file must be processed only when a file is uploaded


    }
    public function createTtableAction(Request $request)
    {
        //create an object to store our data after the form submission
        $table=new Ttime();
        //prepare the form with the function: createForm()
        $form=$this->createForm(createTimeTableType::class,$table);
        //extract the form answer from the received request
        $form=$form->handleRequest($request);
        //if this form is valid
        if($form->isValid()){
            //create an entity manager object
            $em=$this->getDoctrine()->getManager();
            //persist the object $club in the ORM
            $em->persist($table);
            //update the data base with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('class_createTtable');
        }
        return $this->render('@class/Default/createTimeTable.html.twig', array(
            'form'=>$form->createView()
        ));


    }
    public function readTimeTableAction()
    {
        // return $this->render('@Club/Default/read.html.twig');
        //Fetching Objects (Clubs) from the Database
        $timeTable=$this->getDoctrine()->getManager()->getRepository(timetable::class)->findAll();

        //add the list of clubs to the render function as input to be sent to the view
        return $this->render('@class/Default/readTimeTable.html.twig', array('timetable'=>$timeTable ));

    }
    public function deleteTimeTableAction($id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $timetable= $em->getRepository(timetable::class)->find($id);
        //remove from the ORM
        $em->remove($timetable);
        //update the data base
        $em->flush();
        return $this->redirectToRoute("class_searchTimeTable");
    }
    public function updateTimeTableAction(Request $request, $id)
    {
        $class= $this->getDoctrine()->getmanager()->getRepository(timetable::class)->find($id);
        $form= $this->createForm(updateTimeTableType::class,$class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $file=$class->getContent();
            $fileName= uniqid().'.'.$file->getExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $class->setContent($fileName);
            $ef= $this->getDoctrine()->getManager();
            $ef->persist($class);
            $ef->flush();
            return $this->redirectToRoute("class_searchTimeTable");
        }
        return $this->render("@class/Default/updateTimeTable.html.twig",array("form"=>$form->createView()));

    }

    public function searchTimeTableAction(Request $request)
    {
        $timeTable = new timetable();//instance d'entity
        $form= $this->createForm(searchTimeTableType::class,$timeTable);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $timeTable = $this->getDoctrine()->getManager()->getRepository(timetable::class)
                ->findBy(array('classe'=>$timeTable->getClasse()));

        }
        else{
            $timeTable = $this->getDoctrine()->getManager()->getRepository(timetable::class)->findAll();
        }

        $list = $this->getDoctrine()->getManager()->getRepository(timetable::class)->findAll();

        return $this->render("@class/Default/searchTimeTable.html.twig",array("form"=>$form->createView(),'timetable'=>$timeTable,'list'=>$list));


    }

    public function searchTtimeAction(Request $request)
    {
        $time = new Ttime();//instance d'entity
        $form= $this->createForm(searchTtime::class,$time);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $time = $this->getDoctrine()->getManager()->getRepository(Ttime::class)
                ->findBy(array('subject'=>$time->getSubject(),'day'=>$time->getDay(),'time'=>$time->getTime(),'classe'=>$time->getClasse()));
        }
        else{
            $time = $this->getDoctrine()->getManager()->getRepository(Ttime::class)->findAll();
        }
        return $this->render("@class/Default/searchTtime.html.twig",array("form"=>$form->createView(),'time'=>$time));

    }








    public function indexmAction(Request $request)
    {
        $time = new Ttime();
        $form = $this->createForm(readTtimeType::class, $time);
        $form->handleRequest($request);
        $timeTable = $this->getDoctrine()->getManager()->getRepository(Ttime::class)->findBy(array(),array('day'=>'ASC'));
        // replace this example code with whatever you need

        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('@class/Default/index.html.twig', array("form"=>$form->createView(),'time'=>$timeTable )
        );

        $filename = 'time-table';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }


    public function readTimeAction(Request $request)
    {

        $time = new Ttime();
        $form = $this->createForm(readTtimeType::class, $time);
        $form->handleRequest($request);
        $timeTable = $this->getDoctrine()->getManager()->getRepository(Ttime::class)->findBy(array(),array('day'=>'ASC'));

      return $this->render('@class/Default/readTtime.html.twig', array("form"=>$form->createView(),'time'=>$timeTable ));

    }
}
