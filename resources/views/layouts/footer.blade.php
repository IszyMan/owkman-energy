<!-- FOOTER -->
<footer class="footer">

    <div class="footer-container">

        <!-- COLUMN 1: SHOP -->
        <div class="footer-col">
            <h3>Shop</h3>
            <a href="/category/cctv">CCTV Cameras</a>
            <a href="/category/solar">Solar Products</a>
            <a href="/category/smart-watches">Smart Watches</a>
            <a href="/category/smart-glasses">AI Glasses</a>
        </div>

        <!-- COLUMN 2: COMPANY -->
        <div class="footer-col">
            <h3>Company</h3>
            <a href="/about">About Us</a>
            <a href="/contact">Contact</a>
            <a href="/blog">Blog</a>
            <a href="/sitemap.xml">Site Map</a>
            
        </div>

        <!-- COLUMN 3: SUPPORT -->
        <div class="footer-col">
            <h3>Support</h3>
            <a href="/faq">FAQ</a>
            <a href="/shipping">Shipping Info</a>
            <a href="/returns">Returns</a>
            <a href="/terms">Terms & Conditions</a>
        </div>

        <!-- COLUMN 4: CONTACT -->
        <div class="footer-col">
            <h3>Contact</h3>

            <p>Email: support@owkmanenergy.com</p>
            <p>Phone: +234 800 000 0000</p>

            <!-- WhatsApp Button -->
            <a href="https://wa.me/2348000000000" target="_blank" class="whatsapp-btn">
                Chat on WhatsApp
            </a>

            <!-- SOCIAL -->
            <div class="social-icons">
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">X</a>
            </div>
        </div>

    </div>

    <!-- NEWSLETTER 
    <div class="newsletter">
        <h3>Subscribe to our Newsletter</h3>

        <form action="/subscribe" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Enter your email">
            <button type="submit">Subscribe</button>
        </form>
    </div>-->

    <!-- TRUST BADGES 
    <div class="trust-badges">
        <span>🔒 Secure Payment</span>
        <span>🚚 Fast Delivery</span>
        <span>🛡️ Warranty Guaranteed</span>
    </div>-->
       

    <p class="footer-bottom">
        © {{ date('Y') }}
        <a href="{{ url('/') }}" class="footer-brand">Owkman Energy</a>
        . All rights reserved.
    </p>

    <!-- BACK TO TOP -->
    <div class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        ↑ Back to Top
    </div>

    

</footer>