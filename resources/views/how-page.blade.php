@section('title')

{{ ucwords($page->name) }}

@endsection

@extends('layouts.page')

@section('content')
<style>
    .how-list {display:flex; flex-wrap:wrap; max-width:800px; margin:0 auto; border-top:2px dashed #eee; margin-top:30px; padding-top:25px;}
    .how-des {flex:1; text-align:left; padding-left:20px;}
    .how-num {min-width:140px; text-align:right;}
    .how-num h2 {font-weight: 300;
    font-size: 90px; line-height: 65px; color:#888;}
    .how-des  h4 {font-size:18px; font-weight:700;}
    .how-des p {font-size:14px; line-height:20px; margin-top:5px;}
    .start-buy {margin-top:40px;}
    @media (max-width:575px){
          .how-num {text-align:left;}
          .how-des {margin-top:15px; padding-left:0; flex:auto;}   
          .how-des h4 {line-height:26px;}
    }
     @media (max-width:490px){
          .how-num {text-align:left;}
          .how-des {margin-top:10px; padding-left:0; flex:auto;}   
           .how-main h3 {font-size:34px;}
            .how-main .start-sell {padding:30px 15px;}
    }
</style>
  <!-- help page-->
  <section class="reset-page pad-top pad-bot inner-page full-section" style="background:#f3f3f5">
  <div class="container how-main">
         <div class="start-sell text-center">
            <h3><span>Sell</span> Anything</h3>
           <div class="how-wrap">
               <div class="how-list">
                   <div class="how-num">
                       <h2>1.</h2>
                   </div>
                   <div class="how-des">
                       <h4>Register a free account or Login.</h4>
                       <p>Quickly register by providing your name, email, phone number and other details and join our ever-growing Deals Drill.</p>
                   </div>
               </div>
           </div>
            <div class="how-wrap">
               <div class="how-list">
                   <div class="how-num">
                       <h2>2.</h2>
                   </div>
                   <div class="how-des">
                       <h4>Add your item for sale.</h4>
                       <p>Just click on “sell now” and start inserting details like your product’s name, category, photo, etc.</p>
                   </div>
               </div>
           </div>
            <div class="how-wrap">
               <div class="how-list">
                   <div class="how-num">
                       <h2>3.</h2>
                   </div>
                   <div class="how-des">
                       <h4>Buyers will contact you for the purchase.</h4>
                       <p>Now all you have to do is wait for the call from potential buyers. Happy dealing!</p>
                   </div>
               </div>
           </div>
        </div>
        <div class="start-sell start-buy text-center">
            <h3><span>Buy</span> Anything</h3>
           <div class="how-wrap">
               <div class="how-list">
                   <div class="how-num">
                       <h2>1.</h2>
                   </div>
                   <div class="how-des">
                       <h4>Browse or Search for the items you want.</h4>
                       <p>Browse through numerous categories from clothes to furniture, tutoring to graphic design, all your needs is just a click away!</p>
                   </div>
               </div>
           </div>
            <div class="how-wrap">
               <div class="how-list">
                   <div class="how-num">
                       <h2>2.</h2>
                   </div>
                   <div class="how-des">
                       <h4>Take a detailed look at the items.</h4>
                       <p>Details matter. So, make sure everything is according to your requirement before hitting that call button.</p>
                   </div>
               </div>
           </div>
            <div class="how-wrap">
               <div class="how-list">
                   <div class="how-num">
                       <h2>3.</h2>
                   </div>
                   <div class="how-des">
                       <h4>Contact the seller for purchase.</h4>
                       <p>Satisfied with all the details? Call the seller and purchase the product/ book the service.</div>
               </div>
           </div>
        </div>
  </div>
  </section>
@endsection
