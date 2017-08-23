<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Products (ProductsController)
 * Products Class to control all product related operations.
 * @author : Dhananjay
 * @version : 1.1
 * @since : 22 August 2017
 */
class Products extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('products_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function is used to load the product list
     */
    function productListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
             $searchText = $this->input->post('searchText');
             $data['searchText'] = $searchText;
			 
			 $sort_field = $this->input->post('sort_field');
			 
			 if(isset($sort_field) && !empty($sort_field))
                $data['sort_field'] = $sort_field;
			 else
			    $data['sort_field'] = 'name';
			 
			 $sort_ord = $this->input->post('sort_ord');
			 
			 if(isset($sort_ord) && !empty($sort_ord))
                $data['sort_ord'] = $sort_ord;
			 else
			    $data['sort_ord'] = 'asc';
             
			 
            $this->load->library('pagination');
            
            $count = $this->products_model->productListingCount($searchText);

			$returns = $this->paginationCompress ( "productListing/", $count, 5 );
			
			$data['page'] = $returns["page"];
			$data['segment'] = $returns["segment"];
            
            $data['productRecords'] = $this->products_model->productListing($searchText, $data['sort_field'], $data['sort_ord'], $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Sandesh : Product Listing';
            
            $this->loadViews("product_list", $this->global, $data, NULL);
        }
    }
	
	
	 /**
     * This function is used to load the product list
     */
    function itemListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
             $searchText = $this->input->post('searchText');
             $data['searchText'] = $searchText;
			 
			 $sort_field = $this->input->post('sort_field');
			 
			 if(isset($sort_field) && !empty($sort_field))
                $data['sort_field'] = $sort_field;
			 else
			    $data['sort_field'] = 'name';
			 
			 $sort_ord = $this->input->post('sort_ord');
			 
			 if(isset($sort_ord) && !empty($sort_ord))
                $data['sort_ord'] = $sort_ord;
			 else
			    $data['sort_ord'] = 'asc';
				
			 $pid = $this->input->post('pid');
			 
			 if(isset($pid) && !empty($pid))
                $data['pid'] = $pid;
			 else
			    $data['pid'] = '';
             
			 
            $this->load->library('pagination');
            
            $count = $this->products_model->itemListingCount($searchText, $data['pid']);

			$returns = $this->paginationCompress ( "itemListing/", $count, 5);
			
			$data['page'] = $returns["page"];
			$data['segment'] = $returns["segment"];
			
			 $data['products'] = $this->products_model->getProducts();
            
            $data['productRecords'] = $this->products_model->itemListing($searchText, $data['pid'], $data['sort_field'], $data['sort_ord'], $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Sandesh : Product Item Listing';
            
            $this->loadViews("item_list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Sandesh : Add New Product';

            $this->loadViews("addNewProduct", $this->global, NULL, NULL);
        }
    }
	
	 /**
     * This function is used to load the add new form
     */
    function addNewProdItem()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
		    $data['products'] = $this->products_model->getProducts();
			
			//print_r($data['products']);
			
            $this->global['pageTitle'] = 'Sandesh : Add New Product Item';

            $this->loadViews("addNewProductItem", $this->global, $data, NULL);
        }
    }

        /**
     * This function is used to add new user to the system
     */
    function addNewItem()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','name','trim|required|max_length[100]|xss_clean');
			$this->form_validation->set_rules('hsn_gsn_code','hsn_gsn_code','trim|required|max_length[50]|xss_clean');
			$this->form_validation->set_rules('sgst','sgst','trim|required|max_length[50]|xss_clean');
			$this->form_validation->set_rules('cgst','cgst','trim|required|max_length[50]|xss_clean');
			$this->form_validation->set_rules('igst','igst','trim|required|max_length[50]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewProdItem();
            }
            else
            {
                $pid = $this->input->post('pid');
				$hsn_gsn_code = $this->input->post('hsn_gsn_code');
				$name = ucwords(strtolower($this->input->post('name')));
                $sgst = $this->input->post('sgst');
				$cgst = $this->input->post('cgst');
				$igst = $this->input->post('igst');
				$status = $this->input->post('status');
                
                $productInfo = array( 'pid'=> $pid, 
									  'name'=> $name, 
									  'hsn_gsn_code'=> $hsn_gsn_code, 
									  'sgst'=> $sgst, 
									  'cgst'=> $cgst, 
									  'igst'=> $igst,
									  'status'=>$status);
                
                
                $result = $this->products_model->addNewProductItem($productInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product item has been created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product item creation failed');
                }
                
                redirect('addNewProdItem');
            }
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewProd()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $status = $this->input->post('status');
                
                $productInfo = array('name'=> $name,'status'=>$status);
                
                
                $result = $this->products_model->addNewProduct($productInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product has been created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product creation failed');
                }
                
                redirect('addNewProduct');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editProduct($productId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($productId == null)
            {
                redirect('productListing');
            }
            
            $data['productInfo'] = $this->products_model->getProductInfo($productId);
            
            $this->global['pageTitle'] = 'Sandesh : Edit Product';
            
            $this->loadViews("editProduct", $this->global, $data, NULL);
        }
    }
	
	 function deleteProduct()
		{
		   $productId = $this->input->post('prodId');

			$data = array();
			
			if($this->isAdmin() == TRUE)
			{
				$this->loadThis();
			}
			else
			{
				if($productId == null)
				{
					$data['status'] = false;
				}
				
				$deleted = $this->products_model->deleteProd($productId);

			}
			
			if($deleted)
                {
                    $data['status'] = true;
                }
                else
                {
                    $data['status'] = false;
                }
                
                echo json_encode($data);
		}
    
    
    /**
     * This function is used to edit the user information
     */
    function editProd()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $prodId = $this->input->post('prodId');
            
            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editProduct($prodId);
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $status = $this->input->post('status');
                
                $productInfo = array();
                
                
                    $productInfo = array('name'=>$name, 'status'=>$status, 'modified'=>date('Y-m-d H:i:s'));
               
                
                $result = $this->products_model->editProduct($productInfo, $prodId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Product updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product updation failed');
                }
                
                redirect('productListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->products_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'Sandesh : Change Password';
        
        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->products_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->products_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('loadChangePass');
            }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'Sandesh : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>