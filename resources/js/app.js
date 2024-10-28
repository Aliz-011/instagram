import "./bootstrap";

// core version + navigation, pagination modules:
import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";
// import Swiper and modules styles
import "swiper/css";
import "swiper/css/pagination";

window.Swiper = Swiper;
window.Navigation = Navigation;
window.Pagination = Pagination;
