
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>typeahead.js – examples</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">    

    <link rel="stylesheet" href="css/examples.css">  
    <link rel="stylesheet" href="../../templates/restro-theme/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../templates/restro-theme/css/style.css?ver=12.4.1">    
  <body>
    <div class="container">
      <h1 class="title">examples</h1>

      <ol class="table-of-contents">
        <li><a href="#the-basics">The Basics</a></li><span> &middot; </span>
        <li><a href="#bloodhound">Bloodhound</a></li><span> &middot; </span>
        <li><a href="#prefetch">Prefetch</a></li><span> &middot; </span>
        <li><a href="#remote">Remote</a></li><span> &middot; </span>
        <li><a href="#custom-templates">Custom Templates</a></li><span> &middot; </span>
        <li><a href="#default-suggestions">Default Suggestions</a></li><span> &middot; </span>
        <li><a href="#multiple-datasets">Multiple Datasets</a></li><span> &middot; </span>
        <li><a href="#scrollable-dropdown-menu">Scrollable Dropdown Menu</a></li><span> &middot; </span>
        <li><a href="#rtl-support">RTL Support</a></li>
      </ol>

      <div class="example" id="the-basics">
        <h2 class="example-name">The Basics</h2>
        <p class="example-description">
          When initializing a typeahead using the <a href="https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md">typeahead.js jQuery plugin</a>,
          you pass the plugin method one or more <a href="https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md#datasets">datasets</a>. 
          The source of a dataset is responsible for computing a set of 
          suggestions for a given query.
        </p>

        <div class="demo">
          <input class="typeahead" type="text" placeholder="States of USA">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/9458744.js"></script>
        </div>
      </div>

      <div class="example" id="bloodhound">
        <h2 class="example-name">Bloodhound (Suggestion Engine)</h2>
        <p class="example-description">
          For more advanced use cases, rather than implementing the source for
          your dataset yourself, you can take advantage of <a href="https://github.com/twitter/typeahead.js/blob/master/doc/bloodhound.md">Bloodhound</a>, 
          the typeahead.js suggestion engine.
        </p>

        <p class="example-description">
          Bloodhound is robust, flexible, and offers advanced functionalities 
          such as prefetching, intelligent caching, fast lookups, and 
          backfilling with remote data.  
        </p>

        <div class="demo">
          <input class="typeahead" type="text" placeholder="States of USA">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/9458749.js"></script>
        </div>
      </div>

      <div class="example" id="prefetch">
        <h2 class="example-name">Prefetch</h2>
        <p class="example-description">
          Prefetched data is fetched and processed on initialization. If the 
          browser supports local storage, the processed data will be cached 
          there to prevent additional network requests on subsequent page loads.
        </p>

        <div class="demo">
          <input class="typeahead" type="text" placeholder="Countries">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/9458762.js"></script>
        </div>
      </div>

      <div class="example" id="remote">
        <h2 class="example-name">Remote</h2>
        <p class="example-description">
          Remote data is only used when the data provided by local and prefetch 
          is insufficient. In order to prevent an obscene number of requests 
          being made to the remote endpoint, requests are rate-limited.
        </p>

        <div class="demo">
          <input class="typeahead" type="text" placeholder="Oscar winners for Best Picture">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/9458772.js"></script>
        </div>
      </div>
      
      <div class="example" id="custom-templates">
        <h2 class="example-name">Custom Templates</h2>
        <p class="example-description">
          Custom templates give you full control over how suggestions get 
          rendered making it easy to customize the look and feel of your 
          typeahead.
        </p>

        <div class="demo">
          <input class="typeahead" type="text" placeholder="Oscar winners for Best Picture">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/9458780.js"></script>
        </div>
      </div>

      <div class="example" id="default-suggestions">
        <h2 class="example-name">Default Suggestions</h2>
        <p class="example-description">
          Default suggestions can be shown for empty queries by setting the
          minLength option to 0 and having the source return suggestions for 
          empty queries.
        </p>

        <div class="demo">
          <input class="typeahead" type="text" placeholder="NFL Teams">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/ee0e44e70097c211070d.js"></script>
        </div>
      </div>

      <div class="example" id="multiple-datasets">
        <h2 class="example-name">Multiple Datasets</h2>

        <div class="demo">
          <input class="typeahead" type="text" placeholder="NBA and NHL teams">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/9458797.js"></script>
        </div>
      </div>

      <div class="example" id="scrollable-dropdown-menu">
        <h2 class="example-name">Scrollable Dropdown Menu</h2>

        <div class="demo">
          <input class="typeahead" type="text" placeholder="Countries">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/9458816.js"></script>
        </div>
      </div>

      <div class="example" id="rtl-support">
        <h2 class="example-name">RTL Support</h2>

        <div class="demo">
          <input class="typeahead" type="text" dir="rtl" placeholder="نعم">
        </div>

        <div class="gist">
          <script src="https://gist.github.com/jharding/9458824.js"></script>
        </div>
      </div>
    </div>
    <script src="js/handlebars.js"></script>
    <!--<script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/typeahead.bundle.js"></script>-->
    <script src="../../templates/restro-theme/js/jquery-3.4.1.min.js"></script>
    <script src="../../templates/restro-theme/plugins/typeahead/1.2.1/bloodhound.min.js"></script>
    <script src="../../templates/restro-theme/plugins/typeahead/1.2.1/typeahead.jquery.min.js"></script>
    <script src="js/examples.js"></script>    
  </body>
</html>
