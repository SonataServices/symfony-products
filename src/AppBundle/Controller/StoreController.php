<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Document\Store;
use AppBundle\Form\StoreType;

/**
 * Store controller.
 *
 * @Route("/store")
 */
class StoreController extends Controller
{
    /**
     * Lists all Store documents.
     *
     * @Route("/", name="store")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $dm = $this->getDocumentManager();

        $documents = $dm->getRepository('AppBundle:Store')->findAll();

        return array('documents' => $documents);
    }

    /**
     * Displays a form to create a new Store document.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/new", name="store_new")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $document = new Store();
        $form = $this->createForm(new StoreType(), $document);

        return array(
            'document' => $document,
            'form'     => $form->createView()
        );
    }

    /**
     * Creates a new Store document.
     *
     * @Route("/create", name="store_create")
     * @Method("POST")
     * @Template("AppBundle:Store:new.html.twig")
     *
     * @param Request $request
     *
     * @return array
     */
    public function createAction(Request $request)
    {
        $document = new Store();
        $form     = $this->createForm(new StoreType(), $document);
        $form->bind($request);

        if ($form->isValid()) {
            $dm = $this->getDocumentManager();
            $dm->persist($document);
            $dm->flush();

            $this->addFlash(
                'notice',
                'Store created successfully'
            );

            return $this->redirect($this->generateUrl('store_show', array('id' => $document->getId())));
        }

        return array(
            'document' => $document,
            'form'     => $form->createView()
        );
    }

    /**
     * Finds and displays a Store document.
     *
     * @Route("/{id}/show", name="store_show")
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

        $document = $dm->getRepository('AppBundle:Store')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Store document.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Store document.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="store_edit")
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

        $document = $dm->getRepository('AppBundle:Store')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Store document.');
        }

        $editForm = $this->createForm(new StoreType(), $document);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'document'    => $document,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Store document.
     *
     * @Route("/{id}/update", name="store_update")
     * @Method("POST")
     * @Template("AppBundle:Store:edit.html.twig")
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

        $document = $dm->getRepository('AppBundle:Store')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Store document.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createForm(new StoreType(), $document);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $dm->persist($document);
            $dm->flush();

            $this->addFlash(
                'notice',
                'Store edited successfully'
            );

            return $this->redirect($this->generateUrl('store_show', array('id' => $id)));
        }

        return array(
            'document'    => $document,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Store document.
     *
     * @Route("/{id}/delete", name="store_delete")
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
            $document = $dm->getRepository('AppBundle:Store')->find($id);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find Store document.');
            }

            $dm->remove($document);
            $dm->flush();

            $this->addFlash(
                'notice',
                'Store deleted successfully'
            );
        }

        return $this->redirect($this->generateUrl('store'));
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
