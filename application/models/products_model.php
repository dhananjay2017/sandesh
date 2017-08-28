<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends CI_Model
{
    /**
     * This function is used to get the product listing count
     * @return number $count : This is row count
     */
    function productListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_products as BaseTbl');
		if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the product listing count
     * @return number $count : This is row count
     */
    function itemListingCount($searchText = '', $pid = '')
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_product_items as BaseTbl');
		if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
		if(!empty($pid)) {
			$this->db->where("pid", $pid); 
        }
        $query = $this->db->get();
        
        return count($query->result());
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function productListing($searchText = '', $sort_field, $sort_ord, $page, $segment)
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_products as BaseTbl');
		 if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
		$this->db->order_by("BaseTbl.$sort_field $sort_ord"); 
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	
	
	/**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function itemListing($searchText = '', $pid='', $sort_field, $sort_ord, $page, $segment)
    {
        $this->db->select('BaseTbl.*, prod.name as prod_name');
        $this->db->from('tbl_product_items as BaseTbl');
		 $this->db->join('tbl_products as prod', 'prod.id = BaseTbl.pid','left');
		 if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
		if(!empty($pid)) {
			$this->db->where("pid", $pid); 
        }
		
		$this->db->order_by("BaseTbl.$sort_field $sort_ord"); 
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new product to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewProduct($prodInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_products', $prodInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	
	 
    /**
     * This function is used to add new product item to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewProductItem($prodInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_product_items', $prodInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getProductInfo($prodId)
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('id', $prodId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	
	 /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getItemInfo($itemId)
    {
        $this->db->select('*');
        $this->db->from('tbl_product_items');
        $this->db->where('id', $itemId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	 /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information   
     */
    function getProducts()
    {
        $this->db->select('id, name');
        $this->db->from('tbl_products');
		$this->db->order_by("name asc");
        $query = $this->db->get();   
        return $query->result();
    }
	
	 /**
     * This function used to delete product  by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function deleteProd($prodId)
    {
	  
	    $this->db->where('id', $prodId);
        $deleted = $this->db->delete('tbl_products'); 
		
		if($deleted)
		 {
		  $this->deleteProdItems($prodId);
          return true;
		 }
		else
		  return false;
    }
	
	 /**
     * This function used to delete product  by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function deleteItem($itemId)
    {
	  
	    $this->db->where('id', $itemId);
        $deleted = $this->db->delete('tbl_product_items'); 
		if($deleted)
          return true;
		else
		  return false;
    }
	
	 /**
     * This function used to delete product items  by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function deleteProdItems($pid)
    {
	  
	    $this->db->where('pid', $pid);
        $deleted = $this->db->delete('tbl_product_items'); 
		if($deleted)
          return true;
		else
		  return false;
    }
	
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editProduct($prodInfo, $prodId)
    {
        $this->db->where('id', $prodId);
        $this->db->update('tbl_products', $prodInfo);
        
        return TRUE;
    }
	
	  /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editItem($ItemInfo, $ItemId)
    {
        $this->db->where('id', $ItemId);
        $this->db->update('tbl_product_items', $ItemInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }
}

  