<?php

namespace Acme\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\ShopBundle\Base\MainApiController;

/**
 * Contact controller.
 *
 * @Route("/contact")
 */
class ContactController extends MainApiController   
{
    /**
     * Lists all Contact entities.
     * @Route("", name="contact")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    /**
     * Edit a new Contact entity.
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"_method"="PUT", "id"="[\d-]+"})
     * @Method("PUT")
     */
    public function editAction(Request $request, $id)
    {
        return parent::editAction($request, $id);
    }

    /**
     * Creates a new Contact entity.
     * @Route("", defaults={"_format"="json"}, requirements={"_method"="POST"})
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }

    /**
     * Delete a new Contact entity.
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"_method"="DELETE", "id"="[\d-]+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        return parent::deleteAction($request, $id);
    }
        
}
