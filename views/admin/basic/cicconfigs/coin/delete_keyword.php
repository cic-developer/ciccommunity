<h1>hello</h1>
<form class="example" action="post" method="post">
  <input type="text" id="search" placeholder="Search.." name="search">
  <button type="submit"><i class="fa fa-search"></i></button>
</form>
<div>
    <?php 
    $search = $_GET['search']; 
    print_r($search);
    ?>
    
<div>