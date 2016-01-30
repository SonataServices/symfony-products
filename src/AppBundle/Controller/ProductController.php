<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Document\Product;
use AppBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all Product documents.
     *
     * @Route("/", name="product")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $dm = $this->getDocumentManager();

        $documents = $dm->getRepository('AppBundle:Product')->findAll();        
        
        return array('documents' => $documents);
    }

    /**
     * Displays a form to create a new Product document.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/new", name="product_new")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $document = new Product();
        $form = $this->createForm(new ProductType(), $document);

        return array(
            'document' => $document,
            'form'     => $form->createView()
        );
    }

    /**
     * Creates a new Product document.
     *
     * @Route("/create", name="product_create")
     * @Method("POST")
     * @Template("AppBundle:Product:new.html.twig")
     *
     * @param Request $request
     *
     * @return array
     */
    public function createAction(Request $request)
    {
        $document = new Product();
        $form     = $this->createForm(new ProductType(), $document);
        $form->bind($request);

        if ($form->isValid()) {
            $dm = $this->getDocumentManager();
            $dm->persist($document);
            $dm->flush();

            $this->addFlash(
                'notice',
                'Product created successfully'
            );

            return $this->redirect($this->generateUrl('product_show', array('id' => $document->getId())));
        }

        return array(
            'document' => $document,
            'form'     => $form->createView()
        );
    }

    /**
     * Finds and displays a Product document.
     *
     * @Route("/{id}/show", name="product_show")
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

        $document = $dm->getRepository('AppBundle:Product')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Product document.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Product document.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="product_edit")
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

        $document = $dm->getRepository('AppBundle:Product')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Product document.');
        }

        $editForm = $this->createForm(new ProductType(), $document);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'document'    => $document,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Product document.
     *
     * @Route("/{id}/update", name="product_update")
     * @Method("POST")
     * @Template("AppBundle:Product:edit.html.twig")
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

        $document = $dm->getRepository('AppBundle:Product')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Product document.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createForm(new ProductType(), $document);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $dm->persist($document);
            $dm->flush();

            $this->addFlash(
                'notice',
                'Product edited successfully'
            );

            return $this->redirect($this->generateUrl('product_show', array('id' => $id)));
        }

        return array(
            'document'    => $document,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Product document.
     *
     * @Route("/{id}/delete", name="product_delete")
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
            $document = $dm->getRepository('AppBundle:Product')->find($id);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find Product document.');
            }

            $dm->remove($document);
            $dm->flush();

            $this->addFlash(
                'notice',
                'Product deleted successfully'
            );
        }

        return $this->redirect($this->generateUrl('product'));
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
