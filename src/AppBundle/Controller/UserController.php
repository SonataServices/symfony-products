<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Document\User;
use AppBundle\Form\UserType;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User documents.
     *
     * @Route("/", name="user")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $dm = $this->getDocumentManager();

        $documents = $dm->getRepository('AppBundle:User')->findAll();

        return array('documents' => $documents);
    }

    /**
     * Displays a form to create a new User document.
     *
     * @Route("/new", name="user_new")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $document = new User();
        $form = $this->createForm(new UserType(), $document);

        return array(
            'document' => $document,
            'form'     => $form->createView()
        );
    }

    /**
     * Creates a new User document.
     *
     * @Route("/create", name="user_create")
     * @Method("POST")
     * @Template("AppBundle:User:new.html.twig")
     *
     * @param Request $request
     *
     * @return array
     */
    public function createAction(Request $request)
    {
        $document = new User();
        $form     = $this->createForm(new UserType(), $document);
        $form->bind($request);

        if ($form->isValid()) {
            $dm = $this->getDocumentManager();

            //$document->setSalt(md5(uniqid()));
            /*
            $plainPassword = $document->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($document, $plainPassword);
            $document->setPassword($password);
            $document->setRoles(array("ROLE_ADMIN"));
            */
            $dm->persist($document);
            $dm->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $document->getId())));
        }

        return array(
            'document' => $document,
            'form'     => $form->createView()
        );
    }

    /**
     * Finds and displays a User document.
     *
     * @Route("/{id}/show", name="user_show")
     * @Template()
     *
     * @param string $id The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function showAction($id)
    {
        $dm = $this->getDocumentManager();

        $document = $dm->getRepository('AppBundle:User')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find User document.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User document.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Template()
     *
     * @param string $id The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function editAction($id)
    {
        $dm = $this->getDocumentManager();

        $document = $dm->getRepository('AppBundle:User')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find User document.');
        }

        $editForm = $this->createForm(new UserType(), $document);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'document'    => $document,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User document.
     *
     * @Route("/{id}/update", name="user_update")
     * @Method("POST")
     * @Template("AppBundle:User:edit.html.twig")
     *
     * @param Request $request The request object
     * @param string $id       The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function updateAction(Request $request, $id)
    {
        $dm = $this->getDocumentManager();

        $document = $dm->getRepository('AppBundle:User')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find User document.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createForm(new UserType(), $document);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            
            //$document->setSalt(md5(uniqid()));
            /*    
            $plainPassword = $document->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($document, $plainPassword);
            $document->setPassword($password);
            $document->setRoles(array("ROLE_ADMIN"));
            */
            $dm->persist($document);
            $dm->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return array(
            'document'    => $document,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User document.
     *
     * @Route("/{id}/delete", name="user_delete")
     * @Method("POST")
     *
     * @param Request $request The request object
     * @param string $id       The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $dm = $this->getDocumentManager();
            $document = $dm->getRepository('AppBundle:User')->find($id);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find User document.');
            }

            $dm->remove($document);
            $dm->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    private function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }
}
