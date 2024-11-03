<script setup lang="ts">

import type {Product} from "@/Types/types";
import {router, usePage} from '@inertiajs/vue3'
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import {Link} from "@inertiajs/vue3";
import ClientLayout from "@/Layouts/ClientLayout.vue";
import { toast, type ToastOptions } from 'vue3-toastify';
const page = usePage();

 const user = computed(() => page.props.auth.user)

defineProps({
    products: {
        type: Array as () => Product[],
        required: true
    }
})
const cart_count = ref(0)
const addToCart = (productId: number) => {
    router.post('/order/order', {'product_id': productId}, {
        preserveScroll: (page) => page.props.someProp === 'value',
        onSuccess: () => {
            if (user.value) {
                getCartCount()
                toast.success("Item Added to Cart", {
                    autoClose: 2000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                } as ToastOptions);
            }
        }
    })
}
const getCartCount = () => {
    axios.get('/order/cart-count').then((res) => {
        cart_count.value = res.data.count
    }).catch((err) => {
        console.log(err)
    })
}
onMounted(() => {
    getCartCount()
  //    toast("Wow so easy !", {
  //   autoClose: 1000,
  //   position: toast.POSITION.BOTTOM_RIGHT,
  // } as ToastOptions);
})
</script>

<template>
    <ClientLayout :cart_count="cart_count">

        <section id="home" class="home">
            <h1>Welcome to Online Kush Cakes</h1>
            <br>
            <p>We're delighted to have you here! At Kush Cakes, we believe that every occasion deserves a touch of
                sweetness. Our wide range of handcrafted cakes, designed with passion and baked to perfection, is sure
                to bring joy to your celebrations.<br> Explore our gallery to find the perfect cake that matches your
                taste and style. Whether it's a birthday, wedding, or any special event, our cakes are made to create
                memorable moments. Enjoy your visit, and let us add a little sweetness to your day!.</p>
            <div class="home-btn">
                <button style="cursor: pointer;">Cakes Gallery <i class="fas fa-angle-right"
                                                                  style="cursor: pointer;"></i></button>
            </div>
        </section>

        <section class="product" id="product">
            <h1 class="title">Our Most Popular <span>Cakes</span></h1>
            <!-- Search Form -->
            <div class="search-container">
                <form class="search-form" role="search">
                    <input type="text" name="search" placeholder="Search cakes..." class="search-input"
                           aria-label="Search cakes">
                    <button type="submit" class="search-button" title="Search">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <span class="sr-only">Search</span>
                    </button>
                </form>
            </div>
            <div class="cake-product">
                <div class="inner-cake-row">

                    <!--Products 1 -->
                    <div class="inner-cake-col cake-item" data-name="Cocoa Cake" v-for="product in products">
                        <div class="cake-container">
                            <img :src="product.image?.url" :alt="product.name">
                            <div class="cake-reviews">
                                <p>Customer Reviews</p>
                                <ul>
                                    <li v-for="review in product.reviews.slice(0,4)">{{ review.comment }} -
                                        {{ review.user?.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="cake-price">
                            <p>${{ product.price }}</p>
                        </div>
                        <div class="cake-star">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="false"></i>
                        </div>
                        <h2>{{ product.name }}</h2>
                        <h3>{{ product.category?.name }}</h3>
                        <p>{{ product.description }}</p>
                        <span class="add-to-cart" data-name="Cocoa Cake" data-price="20" @click="addToCart(product.id)">Add to Cart</span>
                    </div>


                </div>
            </div>
        </section>


        <section id="service" class="service">
            <h1 class="title">Customize Your <span>Occasion</span></h1>
            <div class="cake-list">
                <a class="btn1 active" data-src="./images/birthday.jpg" data-occasion="birthday">Birthday</a>
                <a class="btn1" data-src="./images/babyshower.jpg" data-occasion="babyshower">Baby-Shower</a>
                <a class="btn1" data-src="./images/wedding.jpg" data-occasion="wedding">Wedding</a>
                <a class="btn1" data-src="./images/cupcake.jpg" data-occasion="cupcake">Cupcake</a>
            </div>

            <div class="cake-row">
                <div class="image">
                    <img src="@/assets/images/fe/birthday.jpg" id="cake-img" alt="Cake Image">
                </div>
                <div class="cake-content">
                    <div class="cake-info">
                        <h3>Customize Your Cake with Flavors <i class="fas fa-birthday-cake"></i></h3>
                        <a class="flavor-btn" data-flavor="Classic Red Velvet">Classic Red Velvet</a>
                        <a class="flavor-btn" data-flavor="Chocolate Vanilla">Chocolate Vanilla</a>
                        <a class="flavor-btn" data-flavor="Double Chocolate">Double Chocolate</a>
                        <a class="flavor-btn" data-flavor="Gluten Free Red Velvet">Gluten Free Red Velvet</a>
                        <a class="flavor-btn" data-flavor="Sugar Free Chocolate">Sugar Free Chocolate</a>
                    </div>
                </div>
            </div>
        </section>
        <section id="testimonial" class="testimonial">

            <div class="cake-info">
                <h1 style="text-decoration-style: dotted;">Testimonials <i class="fas fa-birthday-cake"></i></h1>
            </div>

            <div class="image">
                <img src="@/assets/images/fe/testimo.png" alt="testimonials">
            </div>
        </section>

        <section id="about" class="about">
            <div class="about-content">
                <h2>Kush Cake Story</h2>
                <p>At Kush Cakes, we believe that every celebration deserves a cake that is not only beautiful but also
                    unforgettable in taste. Our team of skilled bakers and decorators works tirelessly to bring your
                    cake dreams to life, whether it’s for a birthday, wedding, baby shower, or any special occasion. We
                    use only the finest ingredients to ensure that every bite is a delight.<br>
                    Our services go beyond just baking cakes. We offer personalized consultations to help you choose the
                    perfect design, flavor, and style for your event. Our gallery showcases a wide range of cake
                    designs, from classic elegance to modern creativity, ensuring that you find inspiration for your
                    perfect cake. <br>
                    The heart of Kush Cakes is our commitment to customer satisfaction. We take pride in our friendly
                    and professional service, making sure that every interaction with our customers is a pleasant and
                    memorable one. Our testimonials page is filled with glowing reviews from satisfied customers who
                    have experienced the magic of Kush Cakes.<br>
                    We invite you to explore our website, browse through our gallery, and read about the experiences of
                    our happy customers. Our contact page makes it easy for you to get in touch with us for inquiries or
                    orders. At Kush Cakes, we are always ready to make your celebrations sweeter and more memorable.

                    Join us on this delightful journey and discover why Kush Cakes is the perfect choice for your next
                    celebration. Let us make your cake dreams come true!.</p>
                <button class="btn">Read More <i class="fas fa-angle-right"></i></button>
            </div>
            <div class="image">
                <img src="@/assets/images/fe/im2.png" alt="About Us Image">
            </div>
        </section>



    </ClientLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Georama:wght@300;400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    font-family: 'Georama', sans-serif;
    box-sizing: border-box;
    text-transform: capitalize;

}

section {
    min-height: 100vh;
    padding: 1rem 10%;
    padding-top: 8rem;
}

/*----------------section-------------*/
.home {
    background: linear-gradient(rgba(241, 155, 155, 0.5), rgba(0, 0, 0, 0.5)), url("@/assets/images/fe/back1.jpg");
    background-position: center;
    background-size: cover;
    color: #fff;
    text-align: center;
}

.home h1 {
    padding-top: 20%;
    font-size: 4rem;
    text-shadow: 2px 2px #fa4975;
    letter-spacing: 1px;
}

.home p {
    font-size: 1.5rem;
    line-height: 2rem;
}

.home-btn {
    padding: 20px 0;
}

.home-btn button {
    width: 15rem;
    padding: 12px 15px;
    border: none;
    border-radius: 5px;
    font-size: 1.2rem;
    font-weight: 600;
    text-align: center;
    letter-spacing: 1px;
    color: #fff;
    background: rgb(236, 35, 119);
}

button i {
    margin-left: .5rem;
    font-size: 1rem;
    text-align: center;
    transition: 2s ease;
    animation: animate .5s ease infinite;
}

button:hover {
    background: rgb(228, 3, 96);

}

@keyframes animate {
    0% {
        transform: translateX(-5px);
    }
    100% {
        transform: translateX(5px);
    }
}

@media (max-width: 768px) {
    .home h1 {
        font-size: 3rem;
        padding-top: 50%;
    }

    .home p {
        font-size: 1.2rem;
    }
}

/*-----------------------about us-----------*/
.about {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.about .about-content {
    width: 100%;
    height: auto;
    padding: 4rem 2rem;
    box-shadow: 0 .2rem .5rem rgb(236, 35, 119);
    text-align: center;
    background: limegreen;
    border-radius: 5px;
}

.about-content h2 {
    font-size: 2.5rem;
    color: #fff;
    padding: .5rem 0;
    letter-spacing: .2rem;
    text-shadow: .2rem .2rem #fa4975;
}

.about-content p {
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.5rem;
    color: #fff;
}

.about .image img {
    width: 100%;
    height: auto;

}

.about .image img:hover {
    animation: animate-img 5s ease infinite;
}

.btn {
    margin: 10px 0;
    width: 10rem;
    padding: .6rem;
    border-radius: 5px;
    border: none;
    background: rgb(236, 35, 119);
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: .1rem;

}

@keyframes animate-img {
    0%, 100% {
        transform: translateX(-3rem);
    }
    25% {
        transform: translateY(5rem);
    }
    50% {
        transform: translateX(3rem);
    }
    75% {
        transform: translateY(-5rem);
    }
}

@media (max-width: 768px) {
    .about {
        display: block;
        justify-content: space-between;
        align-items: center;
    }
}

/*----------------------Product---------------*/
.title {
    text-align: center;
    font-size: 3rem;
    padding: 0.5rem;
    color: rgb(236, 35, 119);
}

.title span {
    color: limegreen;
}

.cake-product .inner-cake-row {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}

.cake-product .inner-cake-col {
    max-width: 1300px;
    background: #fff;
    height: 27rem;
    flex: 1 1 20rem;
    padding: 1.2rem;
    margin: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 .3rem .6rem rgb(236, 35, 119);
    text-align: center;
}

.cake-product .inner-cake-col:hover {
    transition: .5s ease;
    transform: translateY(-.5rem);
}

.cake-product .inner-cake-col img {
    height: 15rem;
    width: 100%;
    object-fit: cover;
}

.cake-product .inner-cake-col .cake-price p {
    position: absolute;
    width: 2.7rem;
    height: auto;
    margin-top: -1.2rem;
    margin-left: 8rem;
    padding: .8rem .1rem;
    text-align: center;
    font-size: 1.2rem;
    border: none;
    border-radius: 6rem;
    background: lightgray;
    color: #000;
}

.cake-star {
    color: #FFDF00;
    position: relative;
    margin-top: 1.7rem;
}

.cake-product .inner-cake-col h2 {
    padding: .5rem 0;
    color: darkblue;
    font-size: 1.3rem;
    letter-spacing: .1rem;
}

.cake-product .inner-cake-col h3 {
    color: gray;
    font-size: 1.2rem;
    font-weight: 500;
}

.cake-product .inner-cake-col p {
    color: gray;
    font-size: 1rem;
    font-weight: 500;
    padding: .5rem 0;
}

@media (max-width: 768px) {
    .title {
        text-align: center;
        font-size: 2rem;
    }
}

/*----------------------------------services---------*/
.service .cake-list {
    display: flex;
    align-items: center;
    justify-content: center;
    list-style: none;
    padding: 1rem 0;
    margin: 1.5rem 0;
    border-top: .2rem dotted limegreen;
    border-bottom: .2rem dotted limegreen;
}

.service .cake-list .btn1 {
    width: 8rem;
    padding: .6rem;
    border-radius: 5px;
    border: none;
    background: rgb(236, 35, 119);
    color: #fff;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: .1rem;
    margin: 1rem;
    text-align: center;
}

.service .cake-list .btn1.active,
.service .cake-list .btn1:hover {
    transition: .5s ease;
    background: limegreen;
    cursor: pointer;
}

.service .cake-row {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}

.service .cake-row .image {
    margin: 1.5rem;
    padding: 1rem;
    flex: 1 1 21rem;
    border-radius: 1rem;
    box-shadow: 0 .5rem 1rem rgb(236, 35, 119);
}

.service .cake-row .image img {
    width: 100%;
    object-fit: cover;
    height: 20rem;
}

.service .cake-content {
    flex: 1 1 21rem;
}

.service .cake-content .cake-info {
    padding: 1rem 4rem;
}

.service .cake-content .cake-info h3 {
    font-size: 1.5rem;
    color: rgb(236, 35, 119);
}

.service .cake-content .cake-info a i {
    padding: 1rem 1rem 0 0;
    font-size: 1.5rem;
    color: limegreen;
}

.service .cake-content .cake-info a {
    font-size: 1rem;
    font-weight: 600;
    color: darkblue;
    cursor: pointer;
}

.service .cake-content .cake-info a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .service .cake-list .btn1 {
        display: inline-block;
        margin: .2rem;
        font-size: .6rem;
    }
}

/* Cart */

#cart table {
    border-collapse: collapse;
    width: 100%;
    table-layout: fixed;
}

#cart table thead {
    font-weight: 600;
}

#cart table thead td {
    background: #fd8c66;
    color: #fff;
    border: none;
}

.cake-item {
    position: relative;
    overflow: hidden;
}

.cake-container {
    position: relative;
}

.cake-item img {
    width: 100%;
    height: auto;
}

.cake-item .add-to-cart {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 10px 20px;
    background-color: #ff4500;
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0;
}

.cake-item:hover .add-to-cart {
    display: block;
    opacity: 1;
}

.cake-item:hover .add-to-cart {
    display: block;
}

.cake-item .cake-price {
    position: relative;
}

@keyframes blink {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.cake-item:hover .cake-price {
    animation: blink 0.3s infinite;
    color: #ff4500;
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

.cake-container:hover .cake-reviews {
    display: block;
}


</style>
