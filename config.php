<?php

class rootview
{
    public $conn;

    function __construct()
    {
        header("Content-type: application/json; charset=utf-8");
        $this->conn = new PDO("mysql:host=localhost;dbname=news;charset=utf8", "root", "");
    }

    function getPost()
    {
        $sql = "SELECT * FROM Tbl_post ";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetchAll(2);
        echo json_encode($sql_query);
    }

    function Get_user_info($user_id)
    {
        $sql = "SELECT name,mobile,email FROM Tbl_reg where id='$user_id'";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetchAll(2);
        echo json_encode($sql_query);
    }

    function GetRegister($name, $mobile, $email, $pass)
    {
        $array = array();
        $sql = "insert into Tbl_reg(name,mobile,email,pass) values ('$name','$mobile','$email','$pass')";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        if ($this->conn->lastInsertId()) {
            $array['status'] = "ok";
            $array['user_id'] = $this->conn->lastInsertId();
            echo json_encode($array);
        } else {
            $array['status'] = "error";
            echo json_encode($array);
        }

    }

    function Getlogin($mobile, $pass)
    {
        $array = array();
        $sql = "select count(pass) as num,id from tbl_reg where pass='$pass' and mobile='$mobile'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['num'] > 0) {
            $array['status'] = "ok";
            $array['user_id'] = $row['id'];
            echo json_encode($array);
        } else {

            $array['status'] = "error";
            echo json_encode($array);

        }
    }


    public function Set_Addcart($user, $procut, $count)
    {
        $array = array();
        $sql = "select price from tbl_post where id='$procut'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['price'] != null) {


            $sql = "select count(idproduct) as num from tbl_cart where iduser='$user' and idproduct='$procut'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $row_2 = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row_2['num'] > 0) {

                $sql = "select price,count from Tbl_cart where idproduct='$procut' and iduser= '$user'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $row_3 = $stmt->fetch(PDO::FETCH_ASSOC);

                $last_update_price = ($row['price']) * $count;
                $updatelast_price = $row_3['price'] + $last_update_price;
                $updatelast_count = $row_3['count'] + $count;


                $sql = "update tbl_cart set price='$updatelast_price',count='$updatelast_count' where idproduct='$procut' and iduser='$user'";
                $sql_query = $this->conn->prepare($sql);
                $sql_query->execute();


                $sql = "SELECT sum(price) as price from tbl_cart";
                $sql_query = $this->conn->prepare($sql);
                $sql_query->execute();
                $sql_query = $sql_query->fetchAll(2);

                $sql = "select price from Tbl_cart where iduser='$user' and idproduct='$procut'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $row_price = $stmt->fetch(PDO::FETCH_ASSOC);

                $array['status'] = 'ok';
                $array['count'] =  $updatelast_count;
                $array['price'] = $sql_query;
                $array['price_post'] = $row_price['price'];

            } else {

                $lastprice = ($row['price']) * $count;
                $sql = "insert into tbl_cart (iduser,idproduct,count,price) values ('$user','$procut','$count','$lastprice')";
                $sql_query = $this->conn->prepare($sql);
                $sql_query->execute();
                if ($this->conn->lastInsertId()) {
                    $array['status'] = 'ok';

                    $sql = "SELECT sum(price) as price from tbl_cart";
                    $sql_query = $this->conn->prepare($sql);
                    $sql_query->execute();
                    $sql_query = $sql_query->fetchAll(2);
                    $array['price'] = $sql_query;
                } else {
                    $array['status'] = 'error';
                }
            }

        } else {
            $array['status'] = 'error';
        }

        echo json_encode($array);

    }


    public function Set_manficart($user, $procut, $count)
    {
        $array = array();
        $sql = "select price from tbl_post where id='$procut'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['price'] != null) {
            $sql = "select count(idproduct) as num from tbl_cart where iduser='$user' and idproduct='$procut'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $row_2 = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row_2['num'] > 0) {

                $sql = "select price,count from Tbl_cart where idproduct='$procut' and iduser= '$user'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $row_3 = $stmt->fetch(PDO::FETCH_ASSOC);
                $last_update_price = ($row['price']) * $count;
                $updatelast_price = $row_3['price'] - $last_update_price;
                $updatelast_count = $row_3['count'] - $count;

                if ($updatelast_count != 0) {
                    $array['count'] = $updatelast_count;
                    $sql = "update tbl_cart set price='$updatelast_price',count='$updatelast_count' where idproduct='$procut' and iduser='$user'";
                    $sql_query = $this->conn->prepare($sql);
                    $sql_query->execute();
                    $sql = "SELECT sum(price) as price from tbl_cart";
                    $sql_query = $this->conn->prepare($sql);
                    $sql_query->execute();
                    $sql_query = $sql_query->fetchAll(2);


                    $sql = "select price from Tbl_cart where iduser='$user' and idproduct='$procut'";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                    $row_price = $stmt->fetch(PDO::FETCH_ASSOC);
                    $array['status'] = 'ok';
                    $array['price'] = $sql_query;
                    $array['price_post']=$row_price['price'];
                } else {
                    $array['status'] = 'error';
                }
            }

        } else {
            $array['status'] = 'error';
        }

        echo json_encode($array);

    }


    public function Del_cart($id)
    {

        $sql = "select count(id) as num from tbl_cart where id='$id'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row_2 = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row_2['num'] > 0) {
            $array = array();
            $sql = "delete from tbl_cart where id='$id'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $array['status'] = 'ok';
        } else {
            $array['status'] = 'error';
        }

        echo json_encode($array);
    }


    public function Record_cart_get($user)
    {
        $sql = "select * from tbl_post,Tbl_cart where Tbl_post.id=Tbl_cart.idproduct and Tbl_cart.iduser='$user'";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetchAll(2);
        echo json_encode($sql_query);
    }


    public function Set_Add_Address($iduser, $city, $meli, $code, $address, $phone, $tell)
    {

        $array = array();
        $sql = "insert into tbl_address(iduser,city,meli,code,address,phone,tell) values ('$iduser','$city','$meli','$code','$address','$phone','$tell')";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        if ($this->conn->lastInsertId()) {
            $array['status'] = "ok";
            echo json_encode($array);
        } else {
            $array['status'] = "error";
            echo json_encode($array);
        }
    }

    public function Get_Address($user)
    {
        $sql = "select * from tbl_address where iduser='$user'";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetchAll(2);
        echo json_encode($sql_query);
    }

    public function Add_order($iduser, $idaddress)
    {
        $array = array();
        $sql = "SELECT sum(price) as price from tbl_cart where iduser='$iduser' ";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetch(PDO::FETCH_ASSOC);
        $price = (int)$sql_query['price'];
        $code=rand(1,100000);
        $sql = "insert into tbl_order(iduser,idaddress,price,status,code_pardakht) values ('$iduser','$idaddress','$price','0','$code')";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        if ($this->conn->lastInsertId()) {
            $array['status'] = "ok";
            $array['price'] = $price;
            $array['code'] = $code;
            $array['order'] = $this->conn->lastInsertId();
            echo json_encode($array);
        } else {
            $array['status'] = "error";
            echo json_encode($array);
        }
    }

    public function List_order($user)
    {
        $sql = "select * from tbl_order where iduser='$user'";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetchAll(2);
        echo json_encode($sql_query);
    }

    public function More_list_order($idorder)
    {
        $sql = "select * from tbl_order,tbl_address where tbl_order.idaddress=tbl_address.id and tbl_order.id='$idorder'";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetchAll(2);
        echo json_encode($sql_query);
    }

    public function Get_price($code){
        $sql = "select price from tbl_order where code_pardakht='$code'";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetch(PDO::FETCH_ASSOC);
       return $sql_query['price'];
    }

    public function Get_order_update($Authority,$id){
        $sql = "update tbl_order set status=1,Authority='$Authority' where code_pardakht='$id' ";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
    }

    public function Get_Cartpricenumber($iduser)
    {
        $sql = "SELECT sum(price) as price from tbl_cart where iduser='$iduser'";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetchAll(2);
        echo json_encode($sql_query);
    }

    public function Get_pay()
    {
        $sql = "select * from tbl_pay";
        $sql_query = $this->conn->prepare($sql);
        $sql_query->execute();
        $sql_query = $sql_query->fetchAll(2);
        echo json_encode($sql_query);
    }


}