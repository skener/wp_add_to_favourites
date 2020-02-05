<?php

function wf_favor_func($content)
{
    if (!is_single() || !is_user_logged_in()):
        return $content;
    endif;
    $img_src = plugins_url('wf_favourites/img/spin.gif', __DIR__);

    global $post;

    if (is_wf_favourites($post->ID)):
        return
            '<p class="wf-favourites-link"><a data-action="del" href="#" >Remove from favourites</a></p>'
            . $content;
    endif;


    return
        "<img class='spin-hide-p' src='$img_src'/>" .
        '<p class="wf-favourites-link"><a data-action="add" href="#" >Add to favourites</a></p>'
        . $content;
}

function load_plug_scripts()
{
    if (!is_single() || !is_user_logged_in()): return;
    endif;
    global $post;
    wp_register_style('wf_favourites', $src = plugins_url('/wf_favourites/css/css.css'));
    wp_enqueue_style('wf_favourites');

    wp_register_script(
        'wf_favourites',
        $src = plugins_url('/wf_favourites/js/wf_favourites.js'),
        ['jquery'],
        microtime(),
        true
    );
    wp_enqueue_script('wf_favourites');
    wp_localize_script(
        'wf_favourites',
        'wf_favourites',
        [
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wf_favourites'),
            'post_id' => $post->ID
        ]
    );
}


function ajax_wf_del()
{
    if (!wp_verify_nonce($_POST['security'], 'wf_favourites')):
        wp_die('Security error');
    endif;
    $post_id = (int)$_POST['post_id'];
    $user = wp_get_current_user();
    if (!is_wf_favourites($post_id)):
        wp_die('Already deleted');
    endif;

    if (delete_user_meta($user->ID, 'wf_favourites', $post_id)):
        wp_die('Deleted');
    endif;
    wp_die('Cant delete');
}


function ajax_wf_add()
{
    if (!wp_verify_nonce($_POST['security'], 'wf_favourites')):
        wp_die('Security error');
    endif;
    $post_id = (int)$_POST['post_id'];
    $user = wp_get_current_user();
    if (is_wf_favourites($post_id)):
        wp_die('Already added');
    endif;

    if (add_user_meta($user->ID, 'wf_favourites', $post_id)):
        wp_die('Added');
    endif;
    wp_die('Cant add');
}

function is_wf_favourites($post_id)
{
    $user = wp_get_current_user();
    $favourites = get_user_meta($user->ID, 'wf_favourites');
    foreach ($favourites as $favourite):
        if ($favourite == $post_id):
            return true;
        endif;
    endforeach;
    return false;
}