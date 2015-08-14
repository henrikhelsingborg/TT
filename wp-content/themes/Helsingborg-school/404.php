<?php get_header(); ?>

<div class="content-container">
    <div class="row">
        <div class="main-content columns large-12">
            <h1>Sidan kan inte hittas</h1>
            <?php get_search_form(); ?>
            <p style="margin-top:20px;"><?php _e('Den sida du vill nå kan inte hittas. Du kan använda sökfunktionen för att försöka hitta det du letar efter.', 'Helsingborg'); ?></p>
            <p><?php _e('<h3>Det här kan du göra för att hitta det du söker:</h3>', 'Helsingborg'); ?></p>
            <ul>
                <li><?php _e('Kontrollera stavningen. Har du skrivit rätt adress?', 'Helsingborg'); ?></li>
                <li><?php _e('Använd sökrutan ovanför för att söka rätt på det du letar efter.', 'Helsingborg'); ?></li>
                <li><?php printf(__('Gå till <a href="%s">startsidan</a>', 'Helsingborg'), home_url()); ?></li>
                <li><?php _e('Använd <a href="javascript:history.back()">webbläsarens bakåt-knapp</a>', 'Helsingborg'); ?></li>
            </ul>
            <p><?php _e('<h3>Vill du komma i kontakt med Helsingborgs stad?</h3> Du kan ringa till Helsingborg kontaktcenter på telefonnummer 042-10 50 00 för att bli lotsad rätt.', 'Helsingborg'); ?></p>
        </div>
    </div>
</div>

<?php get_footer(); ?>