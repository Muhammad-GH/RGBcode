<?php
$path = preg_replace('/wp-content(?!.*wp-content).*/', '', __DIR__);

include ($path . 'wp-load.php');
//This is the php script which is called by ajax
if (isset($_POST['action']))
{
    global $wpdb;
    $connect = $wpdb->__get('dbh');

    $record_per_page = 10;
    $page = '';
    $output = '';
    //Getting Page number
    if (isset($_POST["page"]))
    {
        $page = $_POST["page"];
    }
    else
    {
        $page = 1;
    }
    $start_from = ($page - 1) * $record_per_page;

//Sorting table
    $sortquery = "";
    if ($_POST['type'])
    {
        $sortquery = "Order by " . $_POST['column'] . " " . $_POST['type'];

    }
//Getting Role
    if ($_POST['role'])
    {
        $role = $_POST['role'];
        $query = "SELECT * FROM wp_users where user_nicename='$role' $sortquery LIMIT $start_from, $record_per_page";

        // echo $query;
        
    }
    else
    {
        $query = "SELECT * FROM wp_users $sortquery LIMIT $start_from, $record_per_page";
        //	echo $query;
        
    }
    $result = mysqli_query($connect, $query);
    
//Generating front end table
    $output .= "  

	 <table  class='table table-bordered' id='myTable'>  
		  <tr> <th width='30%' ><span >S.no  &nbsp;<i onclick=sortdatanew('ID','asc')  class='fas fa-arrow-up'></i> &nbsp <i onclick=sortdatanew('ID','desc')  class='fas fa-arrow-down'></i></span></th> 
			 
			   <th  width='100%'><span >Username  &nbsp;<i onclick=sortdatanew('user_login','asc')  class='fas fa-arrow-up'></i> &nbsp <i onclick=sortdatanew('user_login','desc')  class='fas fa-arrow-down'></i></span></th>  
			   
			   <th onclick='sortTable(2,0)' width='100%'><span>Email  &nbsp;<i onclick=sortdatanew('user_email','asc')  class='fas fa-arrow-up'></i> &nbsp <i onclick=sortdatanew('user_email','desc')  class='fas fa-arrow-down'></i></span></th> 
			   <th  width='70%'>Role</th>  
		  </tr>  
    ";

    $i = 0;
    while ($row = mysqli_fetch_array($result))
    {

        $user = get_userdata($row["ID"]);

        // Get all the user roles as an array.
        $user_roles = $user->roles;

        $output .= '  
		  <tr>    
		       <td>' . $row["ID"] . '</td> 
			   <td> <i class="fas fa-user"></i> ' . $row["user_login"] . '</td>  
			   <td>' . $row["user_email"] . '</td>
			   <td>' . $user_roles[0] . '</td>  
		  </tr>  
	 ';
    }
    $output .= '</table><br /><div align="center">';
    if ($_POST['role'])
    {
        $role = $_POST['role'];

        $page_query = "SELECT * FROM wp_users where user_nicename='$role' ORDER BY id DESC";

    }
    else
    {
        $page_query = "SELECT * FROM wp_users ORDER BY id DESC";

    }
    $page_result = mysqli_query($connect, $page_query);
    $total_records = mysqli_num_rows($page_result);

    $total_pages = ceil($total_records / $record_per_page);
    $classname = "";
    for ($i = 1;$i <= $total_pages;$i++)
    {
        if ($i == $page)
        {
            $classname = "activeclass";
        }
        else
        {
            $classname = "";
        }
        $output .= "<span class='pagination_link $classname' style='cursor:pointer; padding:6px; border:1px solid #ccc;padding:13px' id='" . $i . "'>" . $i . "</span> &nbsp;";
    }
    $output .= '</div> <h5 class="pagestext" style="">
page ' . $page . ' of ' . $total_pages . '</h5>
<br /><br />';
    echo $output;

}

?>
