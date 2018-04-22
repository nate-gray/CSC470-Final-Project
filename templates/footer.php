 <!-- End Changeable Content -->
            
        </main>
        
        <footer container class="siteFooter">
            <p>Design uses <a href="http://concisecss.com/">Consise CSS Framework</a></p>
            <p><?php
                date_default_timezone_set('America/Chicago');
                print date('g:i a l F j');
                ?></p>
        </footer>
        
    </body>
</html>

<?php

ob_end_flush();

?>