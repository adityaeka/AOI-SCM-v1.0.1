<!DOCTYPE html>
<!--
 Tabs
 Copyright (c) 2012 John Peloquin
-->
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <title>Tabs</title>
  <style>
   .tabs nav ul {
    list-style:none;
    overflow:hidden;
    margin:0;
    border:0;
    padding:0;
   }
   .tabs nav li {
    float:left;
    margin:0 0.5em 0 0;
    border:0;
    border-radius:10px 10px 0 0;
    padding:0.5em 1em;
    background:#eee;
   }
   .tabs .container {
    position:relative;
   }
   .tabs section {
    position:absolute;
    left:0;
    top:0;
    box-sizing:border-box;
    width:600px;
    height:300px;
    margin:0;
    border:0;
    border-top-right-radius:10px;
    padding:1em;
    background:#eee;
   }
   .tabs section.default {
    z-index:1;
   }
   .tabs section:target {
    z-index:2;
   }
  </style>
 </head>
 <body>
  <header>
   <h1>Tabs</h1>
  </header>
  <p>This example illustrates a progressively enhanced tab interface using HTML5 and CSS3.</p>
  <div class="tabs">
   <nav>
    <ul>
     <li><a href="#tab-1">Tab 1</a></li>
     <li><a href="#tab-2">Tab 2</a></li>
     <li><a href="#tab-3">Tab 3</a></li>
    </ul>
   </nav>
   <div class="container">
    <section class="default" id="tab-1">
     <header>
      <h2>Tab 1</h2>
     </header>
     <p>This is the first tab.</p>
    </section>
    <section id="tab-2">
     <header>
      <h2>Tab 2</h2>
     </header>
     <p>This is the second tab.</p>
    </section>
    <section id="tab-3">
     <header>
      <h2>Tab 3</h2>
     </header>
     <p>This is the third tab.</p>
    </section>
   </div>
  </div>
 </body>
</html>