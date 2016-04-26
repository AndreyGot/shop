<?php

namespace Acme\ShopBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Acme\ShopBundle\Base\ApiResponse;
use Acme\ShopBundle\Event\EntityChangeEvent;

class MainApiController extends Controller
{
    public function getCurrentEntityName()
    {
        $arrayMaches = [];
        $className   = get_class($this);
        preg_match('/^Acme\\\ShopBundle\\\Controller\\\(.*)Controller/', $className, $arrayMaches);
        return end($arrayMaches);
    }
    public function getCurrentForm($entityName)
    {
        return "Acme\ShopBundle\Form\\{$entityName}Type";
    }

    public function getCurrentEntityPath($entityName)
    {
        return "Acme\ShopBundle\Entity\\{$entityName}";
    }

    public function indexAction(Request $request)
    {
        $currentEntityName = $this->getCurrentEntityName();
        if (!$currentEntityName) {
            return ApiResponse::bad('Controller name is not valid (it is indexAction).');
        }

        $search     = $request->query->all();
        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("AcmeShopBundle:{$currentEntityName}");
        $entities   = $repository->paginatedSearch($search);
        $ret        = [];
        
        foreach ($entities as $entity) {
            $ret[]   = $entity -> toArray();
        }
        return ApiResponse::ok($ret);
    }

    public function editAction(Request $request, $id)
    {
        $data    = array();
        $content = $request->getContent();
        if (!empty($content))
        {
            $data = json_decode($content, true); // 2nd param to get as array
        }
        $em = $this->getDoctrine()->getManager();
        $currentEntityName = $this->getCurrentEntityName();
        if (!$currentEntityName) {
            return ApiResponse::bad('Controller name is not valid (it is editAction).');
        }
        $entity = $em->getRepository("AcmeShopBundle:{$currentEntityName}")->findOneById($id);
        if (!$entity) {
            return ApiResponse::bad("Unable to find {$currentEntityName} entity.");
        }
        
        $entityForm = $this->getCurrentForm($currentEntityName);

        $form           = $this->createForm(new $entityForm, $entity); 
        $relationFields = $form->all();
        $data           = array_intersect_key($data, $relationFields);

        $form->submit($data);
        if ($form->isValid()) {
            $this->populateEntityRelations($entity);

            $eventName = strtolower($currentEntityName); 
            $eventName = "{$eventName}_change";

            $event      = new EntityChangeEvent($this, $entity, $data, 'edit');
            $dispatcher = $this->get('event_dispatcher'); 
            $dispatcher->dispatch($eventName, $event);

            $em->persist($entity);
            $em->flush();
            return ApiResponse::ok($entity->toArray());
        } else {
            $errors = $this->getFormErrorMessages($form);
            return ApiResponse::bad($errors);
        }
    }

    public function createAction(Request $request)
    {
        $content = $request->getContent();
        if (!empty($content)) {
            $data = json_decode($content, true); // 2nd param to get as array
        }

        $em                = $this->getDoctrine()->getManager();
        $currentEntityName = $this->getCurrentEntityName();

        $entityClassName = $this->getCurrentEntityPath($currentEntityName);
        $entity          = new $entityClassName;
        $entityForm      = $this->getCurrentForm($currentEntityName);
        $form            = $this->createForm(new $entityForm, $entity); 
        $relationFields  = $form->all();
        $data            = array_intersect_key($data, $relationFields);
        $form->submit($data);

        if ($form->isValid()) {
            $this->populateEntityRelations($entity);

            $eventName  = strtolower($currentEntityName); 
            $eventName  = "{$eventName}_change";
            
            $event      = new EntityChangeEvent($this, $entity, $data, 'create');
            $dispatcher = $this->get('event_dispatcher'); 
            $dispatcher->dispatch($eventName, $event);

            $em->persist($entity);
            $em->flush();
           return ApiResponse::ok($entity->toArray());
        } else {
            $errors = $this->getFormErrorMessages($form);
            return ApiResponse::bad($errors);
        }
    }

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $currentEntityName = $this->getCurrentEntityName();
        if (!$currentEntityName) {
            return ApiResponse::bad('Controller name is not valid.');
        }
        $entity = $em->getRepository("AcmeShopBundle:{$currentEntityName}")->findOneById($id);
        if (!$entity) {
            return ApiResponse::bad("Unable to find {$currentEntityName} entity.");
        }
        $oldEntity = clone($entity);        
        $em->remove($entity);
        $em->flush();

        return ApiResponse::ok($entity->toArray());
    }

    private function populateEntityRelations ($entity)
    {
        $em       = $this->getDoctrine()->getManager();
        $metadata = $em->getClassMetaData(get_class($entity));
        if (!empty($metadata->associationMappings)) {

            foreach ($metadata->associationMappings as $relation) {
                $targetEntityClass = $relation['targetEntity'];
                $method          = 'get' . ucfirst($relation['fieldName']);

                if( !method_exists($entity, $method.'Id') ){
                    continue;
                }
            
                $relEntityId = $entity->{$method.'Id'}();

                if ( $relEntityId ) {
                    $relObject = $em->find($targetEntityClass, $relEntityId);
                    $set_method = 'set' . ucfirst($relation['fieldName']);
                    $entity->{$set_method}($relObject);
                }
            }
        }
    }

    public function getFormErrorMessages ($form)
    {
        $errorsArr = [];
        // @var Symfony\Component\Form\FormErrorIterator $form->getErrors(true)
        foreach ($form->getErrors(true) as $key => $error) {
          $errorsArr[] = $error->getMessage();
        }
        return $errorsArr;
    }

    public function viewAction (Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $currentEntityName = $this->getCurrentEntityName();
        if (!$currentEntityName) {
         return ApiResponse::bad('Controller name is not valid (it is editAction).');
        }
        $entity = $em->getRepository("AcmeShopBundle:{$currentEntityName}")->findOneById($id);
        if (!$entity) {
         return ApiResponse::bad("Unable to find {$currentEntityName} entity.");
        }

        return ApiResponse::ok($entity->toArray());       
    }
}



