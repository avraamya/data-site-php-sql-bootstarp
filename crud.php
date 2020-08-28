<?php
class crud
{
    public $connect;
    private $host = "127.0.0.1";
    private $username = 'root';
    private $password = '';
    private $database = 'test';
    function __construct()
    {
        $this->database_connect();
    }
    public function database_connect()
    {
        $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    }
    public function execute_query($query)
    {
       return mysqli_query($this->connect, $query);
    }
    public function get_image($query)
    {
        $result = $this->execute_query($query);
        $row = mysqli_fetch_object($result);
        return $row->picture;
    }
    public function delete_image($state,$prevPicture)
    {
        $needDelete = 0;
        $query = "SELECT * FROM product ORDER BY id ASC";
        $result = $this->execute_query($query);
        if ($state == 'Delete')
        {
            while($row = mysqli_fetch_object($result))
            {
                if($row->picture == $prevPicture)
                {
                    $needDelete++;
                }
            }
            if ($needDelete == 1)
            {
                unlink($prevPicture);
            }

        }
        else if ($state == 'Edit')
        {
            while($row = mysqli_fetch_object($result))
            {
                if($row->picture == $prevPicture)
                {
                    $needDelete++;
                }
            }
            if ($needDelete == 0)
            {
                unlink($prevPicture);
            }
        }
    }
    public function print_table($query)
    {
        $output = '';
        $result = $this->execute_query($query);
        // .= is to append strings
        $output .= '  
           <table class="table table-striped table-responsive"> 
                <tr>  
                     <th>Name</th>
                     <th>Description</th>
                     <th>Price</th>         
                     <th>Picture</th>   
                     <th>Update</th>  
                     <th>Delete</th>  
                </tr>  
           ';
        while($row = mysqli_fetch_object($result))
        {
            $output .= '  
                <tr>        
                     <td>'.$row->name.'</td>  
                     <td>'.$row->description.'</td>
                     <td>'.$row->price.'</td>
                     <td><img src="'.$row->picture.'" class="img-responsive" width="150" height="150" /></td>
                     <td><button type="button" name="update" id="'.$row->id.'" class="btn btn-success btn-xs update">Update</button></td>  
                     <td><button type="button" name="delete" id="'.$row->id.'" class="btn btn-warning btn-xs delete">Delete</button></td>        
                </tr>  
                ';
        }
        $output .= '</table>';
        return $output;
    }
    function upload_file($file)
    {
        if(isset($file))
        {
            $extension = explode('.', $file["name"]);
            if($extension[1]=!preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $file["name"])) {
                $file["name"] = '';
            }
            else{
                $destination = './upload/' . $file["name"];
                move_uploaded_file($file['tmp_name'], $destination);
            }
            return $file["name"];
        }
    }
    function validate($type, $data)
    {
        $output='';
        switch($type)
        {
            case 'text':$output = preg_replace("/[^a-zA-Z ]/","",$data);
            break;
            case 'int':$output = preg_replace("/[^0-9.]/","",$data);
            break;
            case 'string':$output = preg_replace("/[^a-zA-Z0-9 ]/","",$data);
            break;
            case 'search':$output = preg_replace("/[^\p{L}\p{N} ]/u", "", $data);
            break;
        }

        return $output;
    }
}
?>