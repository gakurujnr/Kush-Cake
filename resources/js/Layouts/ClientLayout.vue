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
</style>
