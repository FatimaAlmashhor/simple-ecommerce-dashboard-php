<?php 
    class Products{
        private $products ;
        
        function getProducts (){
            return $this->$products ;
        }
        
        function getProductByKet($key){
            return $this->$products[$key]
        }

        function getProductByIndex($index){

        }

        function setProducts($value){
            $this->$products = $value ;
        }

        function addNewProduct(){

        }
    }
?>