<script setup lang="ts">

import {Link} from "@inertiajs/vue3";
import axios from "axios";
import {onMounted, ref} from "vue";


const props = defineProps({
    cart_count: {
        type: Number,
        required: false
    }
})
const getCartCount = () => {
    axios.get('/order/cart-count').then((res) => {
        props.cart_count = res.data.count
    }).catch((err) => {
        console.log(err)
    })
}
if (props.cart_count === undefined) {
    getCartCount()
}
</script>

<template>
     <div id="template_div">
          <header>
                    <a href="#home" class="logo"><img src="@/assets/images/fe/logo.png" alt="Cake Shop Logo"></a>
                    <nav class="navigate">
                        <ul>
                            <li><a href="#home">Homepage</a></li>
                            <li><a href="#product">Gallery</a></li>
                            <li><a href="#service">Ordering</a></li>
                            <li><a href="#testimonial">Testimonial</a></li>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#contact">Contact</a></li>

                        </ul>
                    </nav>
                    <div id="menu"><i class="fas fa-bars"></i></div>
                    <Link :href="route('order.cart')">
                    <div  class="cart-icon cursor-pointer">
                        <img src="@/assets/images/fe/cart-logo.png" alt="Cart">
                        <span class="item-count">{{cart_count}}</span>
                    </div>

                        </Link>


        </header>

         <slot></slot>

           <footer class="contact" id="contact">
            <div class="cake-contact">
                <div class="cake-contact-row">
                    <div class="cake-contact-col">
                        <img src="@/assets/images/fe/imm1.jpg" alt="Contact Image" class="images">
                    </div>
                    <div class="cake-contact-col">
                        <h1>Contact Us</h1>
                        <div class="social">
                            <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.pinterest.com" target="_blank"><i class="fab fa-pinterest"
                                                                                   style="font-size: 24px; color: white;"></i></a>
                            <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"
                                                                                 style="font-size: 24px; color: white;"></i></a>
                        </div>
                        <p>Queen Street. Total number of Queen Streets in Australia, Australia 94158<br>123-456-7890</p>
                        <p>We want to hear from you, write us:</p>
                        <form id="formdetails" method="get">
                            <input type="text" name="name" id="name" placeholder="Please Enter Your Name" required>
                            <input type="email" name="email" id="email" placeholder="Please Enter Your E-mail" required>
                            <input type="tel" name="mobile" id="mobile" placeholder="Please Enter Your Mobile No."
                                   required>
                            <textarea rows="8" cols="10" name="msg" placeholder="Give Your Opinion"></textarea>
                            <button class="btn" style="cursor: pointer;">Submit <i class="fas fa-angle-right"
                                                                                   style="cursor: pointer;"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d59017.853243965386!2d72.74254603725106!3d22.405835692956025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1scake%20shop!5e0!3m2!1sen!2sin!4v1628243773361!5m2!1sen!2sin"
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="copyright">
                <a href="#home"><i class="fas fa-arrow-circle-up"></i></a>
                <p>By&copy;Kush Cakes Vision 2025</p>
            </div>
        </footer>
     </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Georama:wght@300;400;500&display=swap');
#template_div{
  scroll-behavior: smooth;
}
* {
    margin: 0;
    padding: 0;
    font-family: 'Georama', sans-serif;
    box-sizing: border-box;
    text-transform: capitalize;

}

html {
    font-size: 15px;
    scroll-behavior: smooth;

}

html::-webkit-scrollbar {
    width: .8rem;
}

html::-webkit-scrollbar-thumb {
    background: rgb(236, 35, 119);
}



header {
    position: sticky;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background: whitesmoke;
    padding: 1rem;
    box-shadow: 0 .2rem .3rem lightgray;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

header .navigate {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

header .logo img {
    height: 40px;
    width: 40px;
    object-fit: cover;

}

.cart-icon img {
    height: 50px;
    width: 50px;
    object-fit: cover;
}

header .navigate ul {
    display: flex;
    align-items: center;
    justify-content: center;
    list-style: none;
}

header .navigate ul li {
    margin-left: 3rem;
}

header .navigate ul li a {
    font-size: 1.2rem;
    color: limegreen;
    text-decoration: none;
    font-weight: 500;
}

header .navigate ul li a.active,
header .navigate ul li a:hover {
    color: rgb(236, 35, 119);
}

header #menu {
    font-size: 2rem;
    color: rgb(236, 35, 119);
    cursor: pointer;
    display: none;
}

@media (max-width: 768px) {
    header #menu {
        display: block;
    }

    header .navigate {
        position: fixed;
        top: 8rem;
        left: 0;
        width: 100%;
        background: aliceblue;
        transform: scaleY(0);
        transform-origin: top;
        opacity: 0;
    }

    header .navigate ul {
        flex-flow: column;
        padding: 1rem;
    }

    header .navigate ul li {
        margin: 1rem;
        width: 100%;
    }

    header .navigate ul li a {
        display: block;
        color: #000;
        padding-left: 2rem;
        border-right: .1rem solid #000;
        font-size: 1rem;
    }

    header .navigate ul li a:hover,
    header .navigate ul li a.active {
        color: rgb(236, 35, 119);
        border-color: rgb(236, 35, 119);
    }

    header .navigate.nav-toggle {
        transform: scaleY(1);
        opacity: 1;
    }

    .fa-times {
        transition: .5s ease;
        transform: rotate(180deg);
    }
}
.cart-icon img {
    animation: bounce 2s infinite;
}
.cart-icon {
    position: relative;
    display: inline-block;
    margin-left: 10px;
    background-color: aliceblue;
    padding: 5px;
    border-radius: 5px;
}

.cart-icon img {
    width: 30px; /* Adjust size as needed */
    height: auto;
    cursor: pointer;
    vertical-align: middle;
}

.item-count {
    position: absolute;
    top: -8px; /* Adjust position above the cart icon */
    right: -8px; /* Adjust position above the cart icon */
    background-color: red; /* Badge background color */
    color: white; /* Badge text color */
    border-radius: 50%; /* Makes it a circle */
    padding: 5px; /* Adjust size as needed */
    font-size: 12px; /* Adjust font size */
}
.logo img {
    animation: rotate 5s linear infinite;
}
@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}


@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateX(8px);
    }
    40% {
        transform: translateX(15px);
    }
    60% {
        transform: translateX(20px);
    }
}


/*---------------------contact us---------*/
.contact {
    padding-top: 8.5rem;
}

.cake-contact {
    width: 100%;
    background: whitesmoke;
}

.cake-contact-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}

.cake-contact-col {
    margin: 2rem;
    flex: 1 1 20rem;
    text-align: center;
}

.cake-contact-col .images {
    border: 1px solid #fff;
}

.cake-contact-col img {
    width: 90%;
    height: auto;
    margin: 1.5rem;
    padding: 1rem;
    flex: 1 1 21rem;
    border: 1px solid transparent;
    border-radius: 1rem;
}

.cake-contact-col h1 {
    padding: 1rem 0;
    color: rgb(236, 35, 119);
    letter-spacing: .1rem;
}

.cake-contact-col .social i {
    padding: .8rem;
    border: none;
    border-radius: 1rem;
    background: rgb(236, 35, 119);
    color: #fff;
    font-size: 1.5rem;
}

.cake-contact-col .social i:hover {
    transition: 0.5s ease;
    background: limegreen;
    color: #fff;
    cursor: pointer;
}

.cake-contact-col p {
    padding: .5rem 0;
    line-height: 1.5rem;
    color: gray;
}

.cake-contact-col input, .cake-contact-col textarea {
    width: 80%;
    padding: 1rem;
    margin-bottom: 1.2rem;
    border: none;
    border-bottom: .1rem dotted rgb(236, 35, 119);
}

.cake-contact-col textarea {
    resize: none;
}

.copyright {
    margin-top: 5rem;
    padding: 3rem;
    text-align: center;
    background: gray;
}

.copyright i {
    font-size: 2rem;
    color: #fff;
}

.copyright p {
    letter-spacing: .1rem;
    font-size: 1.5rem;
    color: #fff;
}

.cake-container {
    position: relative;
}

.cake-img {
    width: 100%;
    height: auto;
    display: block;
}

.cake-reviews {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff;
    padding: 20px;
    box-sizing: border-box;
    text-align: left;
    cursor: pointer;
}

.cake-container:hover .cake-reviews {
    display: block;
}

/* Search form styles */
.search-container {
    display: inline-block;
    margin-left: 20px;
}

.search-form {
    display: flex;
    align-items: center;
}

.search-input {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    width: 200px; /* Adjust width as needed */
}

.search-button {
    background-color: #f5f5f5;
    border: none;
    border-radius: 5px;
    padding: 5px;
    cursor: pointer;
    margin-left: 5px;
}

.search-button i {
    color: #333;
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}

.add-to-cart {
    cursor: pointer;
    border-radius: 20px;
}

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}


@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateX(8px);
    }
    40% {
        transform: translateX(15px);
    }
    60% {
        transform: translateX(20px);
    }
}


</style>
