<script setup lang="ts">

import {Link, router, usePage} from "@inertiajs/vue3";
import axios from "axios";
import {onMounted, ref, watch, computed} from "vue";
import {toast, type ToastOptions} from 'vue3-toastify';

const page = usePage();
const user = computed(() => page.props.auth.user)

const props = defineProps({
    cart_count: {
        type: Number,
        required: false
    }
})
const openCart = () => {
    if (props.cart_count === 0 || !props.cart_count) {
        alert("Please Add in Item on cart to proceed")
        toast.error("Please Add in Item on cart to proceed", {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        } as ToastOptions);
    } else {
        router.visit('/order/cart')
    }
}
const logout = () => {
    router.post(route('logout'));
};
const currentYear = new Date().getFullYear();
</script>

<template>
    <div id="template_div">
        <header>
            <a href="/#home" class="logo"><img src="@/assets/images/fe/logo.png" alt="Cake Shop Logo"></a>
            <nav class="navigate">
                <ul>
                    <li><a href="/#home">Homepage</a></li>
                    <li><a href="/#product">Gallery</a></li>
                    <li><a href="/#service">Ordering</a></li>
                    <li><a href="/#testimonial">Testimonial</a></li>
                    <li><a href="/#about">About Us</a></li>
                    <li><a href="/#contact">Contact</a></li>
                    <li v-if="!user">
                        <Link :href="route('login')">Login</Link>
                    </li>
                    <li v-if="!user">
                        <Link :href="route('register')">Register</Link>
                    </li>
                    <li v-if="user">
                        <Link :href="route('order.index')">My Orders</Link>
                    </li>
                    <li v-if="user"><span class="cursor-pointer" @click="logout">Logout</span></li>
                </ul>
            </nav>
            <div id="menu"><i class="fas fa-bars"></i></div>
            <div class="cart-icon cursor-pointer" @click="openCart">
                <img src="@/assets/images/fe/cart-logo.png" alt="Cart">
                <span class="item-count">{{ cart_count }}</span>
            </div>
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
                        <div class="flex flex-row justify-center">
                            <a href="https://www.facebook.com" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                                     viewBox="0 0 50 50">
                                    <path
                                        d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M37,19h-2c-2.14,0-3,0.5-3,2 v3h5l-1,5h-4v15h-5V29h-4v-5h4v-3c0-4,2-7,6-7c2.9,0,4,1,4,1V19z"></path>
                                </svg>
                            </a>
                            <a href="https://www.instagram.com" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                                     viewBox="0 0 48 48">
                                    <radialGradient id="yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1" cx="19.38" cy="42.035"
                                                    r="44.899" gradientUnits="userSpaceOnUse">
                                        <stop offset="0" stop-color="#fd5"></stop>
                                        <stop offset=".328" stop-color="#ff543f"></stop>
                                        <stop offset=".348" stop-color="#fc5245"></stop>
                                        <stop offset=".504" stop-color="#e64771"></stop>
                                        <stop offset=".643" stop-color="#d53e91"></stop>
                                        <stop offset=".761" stop-color="#cc39a4"></stop>
                                        <stop offset=".841" stop-color="#c837ab"></stop>
                                    </radialGradient>
                                    <path fill="url(#yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1)"
                                          d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"></path>
                                    <radialGradient id="yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2" cx="11.786" cy="5.54"
                                                    r="29.813" gradientTransform="matrix(1 0 0 .6663 0 1.849)"
                                                    gradientUnits="userSpaceOnUse">
                                        <stop offset="0" stop-color="#4168c9"></stop>
                                        <stop offset=".999" stop-color="#4168c9" stop-opacity="0"></stop>
                                    </radialGradient>
                                    <path fill="url(#yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2)"
                                          d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"></path>
                                    <path fill="#fff"
                                          d="M24,31c-3.859,0-7-3.14-7-7s3.141-7,7-7s7,3.14,7,7S27.859,31,24,31z M24,19c-2.757,0-5,2.243-5,5	s2.243,5,5,5s5-2.243,5-5S26.757,19,24,19z"></path>
                                    <circle cx="31.5" cy="16.5" r="1.5" fill="#fff"></circle>
                                    <path fill="#fff"
                                          d="M30,37H18c-3.859,0-7-3.14-7-7V18c0-3.86,3.141-7,7-7h12c3.859,0,7,3.14,7,7v12	C37,33.86,33.859,37,30,37z M18,13c-2.757,0-5,2.243-5,5v12c0,2.757,2.243,5,5,5h12c2.757,0,5-2.243,5-5V18c0-2.757-2.243-5-5-5H18z"></path>
                                </svg>
                            </a>
                            <a href="https://www.pinterest.com" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                                     viewBox="0 0 50 50">
                                    <path
                                        d="M25,2C12.3178711,2,2,12.3178711,2,25c0,9.8841553,6.2675781,18.3302612,15.036377,21.5769653	c-0.2525635-2.2515869-0.2129517-5.9390259,0.2037964-7.7243652c0.3902588-1.677002,2.5212402-10.6871338,2.5212402-10.6871338	s-0.6433105-1.2883301-0.6433105-3.1911011c0-2.9901733,1.7324219-5.2211914,3.8898315-5.2211914	c1.8349609,0,2.7197876,1.3776245,2.7197876,3.0281982c0,1.8457031-1.1734619,4.6026611-1.78125,7.1578369	c-0.506897,2.1409302,1.0733643,3.8865356,3.1836548,3.8865356c3.821228,0,6.7584839-4.0296021,6.7584839-9.8453369	c0-5.147583-3.697998-8.7471924-8.9795532-8.7471924c-6.1167603,0-9.7072754,4.588562-9.7072754,9.3309937	c0,1.8473511,0.7111816,3.8286743,1.6000977,4.9069824c0.175293,0.2133179,0.2009277,0.3994141,0.1488647,0.6160278	c-0.1629028,0.678894-0.5250854,2.1392822-0.5970459,2.4385986c-0.0934448,0.3944702-0.3117676,0.4763184-0.7186279,0.2869263	c-2.685791-1.2503052-4.364502-5.1756592-4.364502-8.3295898c0-6.7815552,4.9268188-13.0108032,14.206543-13.0108032	c7.4588623,0,13.2547607,5.3138428,13.2547607,12.4179077c0,7.4100342-4.6729126,13.3729858-11.1568604,13.3729858	c-2.178894,0-4.2263794-1.132019-4.9267578-2.4691772c0,0-1.0783081,4.1048584-1.3404541,5.1112061	c-0.4524536,1.7404175-2.3892822,5.3460083-3.3615723,6.9837036C20.1704712,47.6074829,22.5397949,48,25,48	c12.6826172,0,23-10.3173828,23-23C48,12.3178711,37.6826172,2,25,2z"></path>
                                </svg>
                            </a>
                            <a href="https://www.twitter.com" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                                     viewBox="0 0 50 50">
                                    <path
                                        d="M 11 4 C 7.134 4 4 7.134 4 11 L 4 39 C 4 42.866 7.134 46 11 46 L 39 46 C 42.866 46 46 42.866 46 39 L 46 11 C 46 7.134 42.866 4 39 4 L 11 4 z M 13.085938 13 L 21.023438 13 L 26.660156 21.009766 L 33.5 13 L 36 13 L 27.789062 22.613281 L 37.914062 37 L 29.978516 37 L 23.4375 27.707031 L 15.5 37 L 13 37 L 22.308594 26.103516 L 13.085938 13 z M 16.914062 15 L 31.021484 35 L 34.085938 35 L 19.978516 15 L 16.914062 15 z"></path>
                                </svg>
                            </a>
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
                <p>By&copy;Kush Cakes Vision {{ currentYear }}</p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Georama:wght@300;400;500&display=swap');

#template_div {
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
