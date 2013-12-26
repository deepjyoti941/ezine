<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>digital magazine</title>
    {{ HTML::style('css/vendor/bootstrap.min.css') }}
   	{{ HTML::style('css/main.css')}}

    {{ HTML::script('/js/vendor/jquery.js') }}
    {{ HTML::script('/js/vendor/bootstrap-datepicker.js') }}
    {{ HTML::script('/js/main.js') }}
  </head>
 
  <body>
  <!--header part start here-->
  <div class="row" style="background-color:#EEEEEE;">
    <div class="span4 offset8">
      <div>
        <p>header part</p>
      </div>
    </div>
  </div>
  <br>


  <!--header part end here-->
    <br><br>
     <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
         <div class="container">
            <ul class="nav"> 
            <li><a class="brand" href="/">Home</a></li>
            @if(!Auth::check())
             <!--  <li><a href="users/register">Register</a></li>
              <li><a href="users/login">Login</a></li> -->
            @else
               <li>{{ HTML::link('users/logout', 'logout') }}</li>
               <!--<li class="dropdown">{{ HTML::link('/category', 'Add category') }}</li>-->
               
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Category <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/category">List Category</a></li>
                    <li class="divider"></li>
                    <li class="nav-header">New</li>
                    <li><a href="/category/add-new-category">Add new Category</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Magazine <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/list-available-magazines">List Magazine</a></li>
                    <li class="divider"></li>
                    <li class="nav-header">New</li>
                    <li><a href="/upload-image-pdf">Upload Image and PDF</a></li>
                  </ul>
                </li>
            @endif
          
          <!--
        <? if (!Auth::check()) { ?>
          <li><a href="users/register">Register</a></li>
          <li><a href="users/login">Login</a></li>
          <ul class="nav pull-right">
            <li><a class="brand" href="/">Home</a></li>
          </ul>
        <? } else { ?>
          <li><a href="logout">Logout</a></li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Category <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/category">List Category</a></li>
                    <li class="divider"></li>
                    <li class="nav-header">New</li>
                    <li><a href="/category/add-new-category">Add new Category</a></li>
                  </ul>
                <li style="float:right;"><a href="/">View Site</a></li>
              </li>
        <? } ?>
        -->
            </ul> 
         </div>
      </div>
   </div>
   <div class="container">
      @if(Session::has('message'))
        <div>
          <p class="alert">{{ Session::get('message') }}</p>
        </div>
      @endif
  <div class="row" style="">
    <div class="span9 offset8">
      <div>
        <form class="form-search search_magazine" action="/search-magazine" method="post">
          <div class="input-append">
            <input type="text" class="span3 search-query" id="search_query" placeholder="search magazine here">
            <button type="submit" class="btn"><i class="icon-search"></i>  </button>
          </div>
        </form>
      </div>
    </div>
</div>
<div class="row">
  <div class="span3 bs-docs-sidebar" style="margin-left: 0px;">
    <ul class="nav nav-list bs-docs-sidenav affix-top">
      <li><a class="category_select all_category" href="#"><i class="icon-chevron-right"></i>All</a></li>
      <? foreach ($magazineCategory as $category) {?>
      <? $url = '/'.$category->category_slug.'/'.$category->id ?>
        <li><a class="category_select" href="<?= $url ?>"><i class="icon-chevron-right"></i><?= $category->category_name ?></a></li>
      <? }?>
    </ul>
  </div>
    <div class="span9 magazine_container" style="margin-top: 20px;">
      <div class="parent_magazines_container">
       {{ $content }}
       </div>
    </div>
    </div>
    <br><br><br>
  <!--footer part start here-->
  <div id="saving_container" style="display:none;">
    <div id="saving" style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
    <img id="saving_animation" src="/css/img/loading_animation.gif" alt="cloning" style="z-index:100001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>
    <div id="saving_text" style="text-align:center; width:100%; position:fixed; left:0px; top:50%; margin-top:40px; color:#fff; z-index:100001">Loading...</div>
  </div>
  <div class="row" id="footer">
    <div class="span4 offset8">
      <div>
        <p>footer part</p>
      </div>
    </div>
  </div>
  <!--footer part end here-->
  </body>
</html>