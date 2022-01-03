<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Builder\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

// use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomerController extends AbstractController
{
    // #[Route('/customer', name: 'customer')]

    // ==================================================FETCH ALL CUSTOMERS LIST======================================================
    public function indexAction(Request $request): JsonResponse
    {
         
          
      $customer =   $this->getDoctrine()->getRepository(Customer::class)->findAll();
    if($customer) {

        $customerList = [];
        foreach($customer as $data) {
            $customerList = [
                'id'=> $data->getId(),
                'name'=> $data->getName(),
                'email'=> $data->getEmail(),
                'mobile'=> $data->getMobile(),
                'city'=> $data->getCity(),
            ];
            
    
        }
          return new JsonResponse(['data'=>$customerList,'status'=>200,'message'=>'Customer`s data fetch..'],Response::HTTP_OK); exit;

    } else { 
        return new JsonResponse(['data'=>[],'status'=>404,'message'=>'customers not found..'],Response::HTTP_OK); exit;

    }
     

       
    }
    // ========================================ADD CUSTOMER============================================

    public function addCustomerAction(Request $request,ValidatorInterface $validator):JsonResponse
     {
        //  echo "</pre>";  
        //  print_r($request->request->all());
        //   die;
        $customerobj = new Customer();
      $customerstoreData = $request->request->all();
//   echo "<pre>"; print_r($customerstoreData); die;
             $customerobj->setName($customerstoreData['name']);
             $customerobj->setEmail($customerstoreData['email']);
             $customerobj->setMobile($customerstoreData['mobile']);
             $customerobj->setCity($customerstoreData['city']);
$errors=NULL;
  $errors = $validator->validate($customerobj);
//   echo "<pre>"; print_r($errors); die("tt");
  if (count($errors) > 0) {  
    //   die("err");
    return new JsonResponse(['data'=>$errors,'status'=>400,'message'=>'Validation Error'],Response::HTTP_OK); exit;
  } else { 
    //   die("test");

    $em =   $this->getDoctrine()->getManager();
    $em->persist($customerobj);
    $em->flush();
 return new JsonResponse(['data'=>[],'status'=>200,'message'=>'Customer added...'],Response::HTTP_OK); exit;

  } 


    }
    // ============================================DELETE CUSTOMER=========================================================

    public function deleteCustomerAction($id, CustomerRepository $custrepo):JsonResponse {
        $em1 = $this->getDoctrine()->getManager();
        $del_res = $custrepo->find($id);
        if($del_res) {
        $em1->remove($del_res);
        $em1->flush();

        return new JsonResponse(['data'=>['id'=>$id],'status'=>200,'message'=>'Customer delete successfully..'],Response::HTTP_OK); exit;
 
        } else {

          return new JsonResponse(['data'=>['id'=>$id],'status'=>400,'message'=>'Customer not found.'],Response::HTTP_OK); exit;

        }
      

    }
    // ===========================================EDIT CUSTOMER DATA=========================================================================================

    public function editCustomerAction(Request $request,ValidatorInterface $validator):JsonResponse  {

     $editArr = $request->request->all();
     $id = $editArr['id'];
    $custObj =   $this->getDoctrine()->getRepository(Customer::class)->find($id);
    if($custObj) {
      // set data for entity
      $custObj->setName($editArr['name']);
      $custObj->setEmail($editArr['email']);
      $custObj->setMobile($editArr['mobile']);
      $custObj->setCity($editArr['city']);
        $errors=NULL;
         $errors =   $validator->validate($custObj);
         if(count($errors) > 0) { 
          return new JsonResponse(['data'=>$errors,'status'=>404,'message'=>'Validation Error. Please fill right information.'],Response::HTTP_OK); exit;
         }  else { 

          $mdle = $this->getDoctrine()->getManager();
          $mdle->persist($custObj);
          $mdle->flush();
          return new JsonResponse(['data'=>['id'=>$id],'status'=>200,'message'=>'Customer updated successfully...'],Response::HTTP_OK); exit;

         }

    } else {
      return new JsonResponse(['data'=>[],'status'=>400,'message'=>'Customer not found.'],Response::HTTP_OK); exit;

    }

    }
 
//  ===========================================CUSTOMER SEARCH FILTER=================================================================

public function customerDataFilterAction(Request $request,CustomerRepository $custRepoo) {

  $filtersData=$request->request->all();

    if($filtersData['search']) {

      $result = $custRepoo->findAllWithSearch($filtersData['search']);
      $finalData = [];
      foreach( $result as $key => $val) { 
      
        $finalData[] = [
         'name' => $val->getName(),
         'email' => $val->getEmail(),
         'mobile' => $val->getMobile(),
         'city' => $val->getCity()
        ];
      
      }

      // echo "<pre>"; print_r($finalData); die("test");
    return new JsonResponse(['data'=>$finalData,'status'=>200,'message'=>'Customer searched...'],Response::HTTP_OK); exit;

        
    } else {
      return new JsonResponse(['data'=>[],'status'=>400,'message'=>'Customer not found.'],Response::HTTP_OK); exit;
        

    }

}
//  ===========================================CUSTOMER SEARCH FILTER END=================================================================
}
