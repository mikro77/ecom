
<div class="upper-bar"> 

<div>
<nav class="navbar navbar-inverse  navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
              <?php      
              $category = getcat(); 
              foreach($category as $cat ) {
              echo '<li>      
  <a href="categories.php?pageid='.  $cat['ID'] . '&sh='   . str_replace(' ', '-',$cat['Name'])   . '  ">
              '. $cat['Name'] . '</a>
              </li>' ;
              }
            ?>
        </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<!--/.nav-collapse 
str_replace(  ' ', '-',$cat['Name']) 


-->



























