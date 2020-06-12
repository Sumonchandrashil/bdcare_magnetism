@include('frontend.header')



<!-- ##################contactLeft#########
    CONTACT SECTION
########################### -->


<section class="contact">
    <div class="container">
        <h1>Contact us</h1>
        <p>
            Have questions about our products, support services, or anything else? Let us know and we’ll get back to you.
        </p>
    </div>
</section>
<br>


<!-- ###########################
    CONTACT FORM SECTION
########################### -->


<section class="contactForm">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="contactLeft" style="border-radius: 12px">
                    <h1>Contact Us</h1>
                    <form style="padding: 12px" action="#">
                        <label>Interested in</label>
                        <select class="custom-select" id="inputGroupSelect02">
                            <option selected>Choose City</option>


                            <?php

                            $cities = \App\Model\BDCare\Setup\City::get();
                            if($cities->count() > 0){
                                foreach ($cities as $city){
                            ?>
                            <option value="{{$city->id}}">{{$city->city_name}}</option>
                            <?php } } ?>
                        </select>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mobile</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your mobile number">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">City</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your city">
                        </div>
                        <div class="form-group">
                            <textarea  class="textarea form-control" placeholder="Message"></textarea>
                        </div>


                        <button type="submit" class="btn btn-primary submitCustom">Submit</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div align="center">
                    <h1 align="center">Our branches</h1>

                        <h3 align="center">Chittagong-1</h3>


                        <div class="getDirection">
                        {{--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.452827845551!2d90.39779621441606!3d23.766884084581207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7784b4f7c03%3A0x2ebc0326accde12e!2sI-Venture+Limited!5e0!3m2!1sen!2sbd!4v1549377251179" class="location" frameborder="0" style="border:0" allowfullscreen></iframe>--}}
                            <div class="mapouter">
                                <div class="gmap_canvas">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14762.7565998225!2d91.815441!3d22.327593!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x96dab365989d6e4b!2sBdcare!5e0!3m2!1sen!2sbd!4v1571310914547!5m2!1sen!2sbd" width="600" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                                </div>
                            </div>
                        </div>

                    <h3 align="center">Chittagong-2</h3>


                    <div class="getDirection">
                        {{--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.452827845551!2d90.39779621441606!3d23.766884084581207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7784b4f7c03%3A0x2ebc0326accde12e!2sI-Venture+Limited!5e0!3m2!1sen!2sbd!4v1549377251179" class="location" frameborder="0" style="border:0" allowfullscreen></iframe>--}}
                        <div class="mapouter">
                            <div class="gmap_canvas">
                                <iframe width="600" height="250" id="gmap_canvas" src="https://maps.google.com/maps?q=%20S.Alam%20Center%20Chittagong%2C%20Bangladesh.&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                            </div>
                        </div>
                    </div>



            </div>
        </div>
    </div>
    <br>
</section>





@include('frontend.footer')
