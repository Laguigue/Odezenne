<?php if (!defined('ABSPATH')) exit;

class FooEvents_Checkout_Helper
{

    private $Config;


    public function __construct($Config)
    {

        $this->Config = $Config;

        add_action('woocommerce_after_order_notes', array($this, 'attendee_checkout'));
        add_action('woocommerce_checkout_process', array($this, 'attendee_checkout_process'));
//        add_action('woocommerce_checkout_update_order_meta', array( $this, 'woocommerce_events_process'));
        add_action('woocommerce_rest_insert_shop_order_object', array($this, 'woocommerce_events_process'));

        if (true === WP_DEBUG) {
            error_log('test 1');
        }

    }

    /**
     * Displays attendee checkout forms on the checkout page
     *
     */
    public function attendee_checkout($checkout)
    {

        global $woocommerce;

        $events = $this->get_order_events($woocommerce);

        foreach ($events as $event => $tickets) {

            $captureAttendees = $this->check_tickets_for_capture_attendees($tickets);

            if ($captureAttendees) {

                echo '<h2>' . __($event) . '</h2>';

                $x = 1;
                foreach ($tickets as $ticket) {

                    $ticketType = '';
                    if (!empty($ticket['attribute_ticket-type'])) {

                        $ticketType = ' - ' . $ticket['attribute_ticket-type'];

                    }

                    if (!empty($ticket['attribute_pa_ticket-type'])) {

                        $ticketType = ' - ' . $ticket['attribute_pa_ticket-type'];

                    }


                    $WooCommerceEventsCaptureAttendeeDetails = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeDetails', true);
                    $WooCommerceEventsCaptureAttendeeTelephone = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeTelephone', true);
                    $WooCommerceEventsCaptureAttendeeCompany = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeCompany', true);
                    $WooCommerceEventsCaptureAttendeeDesignation = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeDesignation', true);

                    if (!empty($ticket['variations'])) {

                        foreach ($ticket['variations'] as $key => $variation) {

                            $variationNameOutput = str_replace('attribute_', '', $key);
                            $variationNameOutput = str_replace('pa_', '', $variationNameOutput);
                            $variationNameOutput = str_replace('_', ' ', $variationNameOutput);
                            $variationNameOutput = str_replace('-', ' ', $variationNameOutput);
                            $variationNameOutput = str_replace('Pa_', '', $variationNameOutput);
                            $variationNameOutput = ucwords($variationNameOutput);

                            echo '<div class="fooevents-variation-desc"><strong>' . $variationNameOutput . ':</strong> ' . $variation . '</div>';

                        }

                    }

                    if ($WooCommerceEventsCaptureAttendeeDetails === 'on') {

                        woocommerce_form_field($ticket['product_id'] . '_attendee_' . $x, array(
                            'type' => 'text',
                            'class' => array('attendee-class form-row-wide'),
                            'label' => sprintf(__('Attendee %d First Name', 'woocommerce-events'), $x),
                            'placeholder' => '',
                            'required' => true,
                        ), $checkout->get_value($ticket['product_id'] . '_attendee_' . $x));

                        woocommerce_form_field($ticket['product_id'] . '_attendeelastname_' . $x, array(
                            'type' => 'text',
                            'class' => array('attendee-class form-row-wide'),
                            'label' => sprintf(__('Attendee %d Last Name', 'woocommerce-events'), $x),
                            'placeholder' => '',
                            'required' => true,
                        ), $checkout->get_value($ticket['product_id'] . '_attendeelastname_' . $x));

                        woocommerce_form_field($ticket['product_id'] . '_attendeeemail_' . $x, array(
                            'type' => 'text',
                            'class' => array('attendee-class form-row-wide'),
                            'label' => sprintf(__('Attendee %d Email', 'woocommerce-events'), $x),
                            'placeholder' => '',
                            'required' => true,
                        ), $checkout->get_value($ticket['product_id'] . '_attendeeemail_' . $x));

                        if ($WooCommerceEventsCaptureAttendeeTelephone === 'on') {

                            woocommerce_form_field($ticket['product_id'] . '_attendeetelephone_' . $x, array(
                                'type' => 'text',
                                'class' => array('attendee-class form-row-wide'),
                                'label' => sprintf(__('Attendee %d Telephone', 'woocommerce-events'), $x),
                                'placeholder' => '',
                                'required' => true,
                            ), $checkout->get_value($ticket['product_id'] . '_attendeetelephone_' . $x));

                        }

                        if ($WooCommerceEventsCaptureAttendeeCompany === 'on') {

                            woocommerce_form_field($ticket['product_id'] . '_attendeecompany_' . $x, array(
                                'type' => 'text',
                                'class' => array('attendee-class form-row-wide'),
                                'label' => sprintf(__('Attendee %d Company', 'woocommerce-events'), $x),
                                'placeholder' => '',
                                'required' => true,
                            ), $checkout->get_value($ticket['product_id'] . '_attendeecompany_' . $x));

                        }

                        if ($WooCommerceEventsCaptureAttendeeDesignation === 'on') {

                            woocommerce_form_field($ticket['product_id'] . '_attendeedesignation_' . $x, array(
                                'type' => 'text',
                                'class' => array('attendee-class form-row-wide'),
                                'label' => sprintf(__('Attendee %d Designation', 'woocommerce-events'), $x),
                                'placeholder' => '',
                                'required' => true,
                            ), $checkout->get_value($ticket['product_id'] . '_attendeedesignation_' . $x));

                        }

                        if (!function_exists('is_plugin_active_for_network')) {

                            require_once(ABSPATH . '/wp-admin/includes/plugin.php');

                        }

                        if ($this->is_plugin_active('fooevents_custom_attendee_fields/fooevents-custom-attendee-fields.php') || is_plugin_active_for_network('fooevents_custom_attendee_fields/fooevents-custom-attendee-fields.php')) {


                            $Fooevents_Custom_Attendee_Fields = new Fooevents_Custom_Attendee_Fields();
                            $Fooevents_Custom_Attendee_Fields->output_attendee_fields($ticket['product_id'], $x, $ticket, $checkout);

                        }

                        $x++;

                    }
                }

            }
        }


    }


    /**
     * Check if attendee details should be captured
     *
     * @param array $tickets
     *
     */
    public function check_tickets_for_capture_attendees($tickets)
    {

        foreach ($tickets as $ticket) {

            $WooCommerceEventsCaptureAttendeeDetails = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeDetails', true);

            if ($WooCommerceEventsCaptureAttendeeDetails === 'on') {

                return true;

            }

        }

        return false;

    }

    /**
     * Processes the attendee details on Checkout
     *
     *
     */
    public function attendee_checkout_process()
    {

        global $woocommerce;

        $events = $this->get_order_events($woocommerce);

        foreach ($events as $event => $tickets) {

            $x = 1;
            foreach ($tickets as $ticket) {

                $WooCommerceEventsCaptureAttendeeDetails = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeDetails', true);
                $WooCommerceEventsCaptureAttendeeTelephone = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeTelephone', true);
                $WooCommerceEventsCaptureAttendeeCompany = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeCompany', true);
                $WooCommerceEventsCaptureAttendeeDesignation = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeDesignation', true);

                if ($WooCommerceEventsCaptureAttendeeDetails === 'on') {

                    if (!$_POST[$ticket['product_id'] . '_attendee_' . $x]) {

                        $notice = sprintf(__('Name is required for %s attendee %d', 'woocommerce-events'), $event, $x);
                        wc_add_notice($notice, 'error');

                    }

                    if (!$_POST[$ticket['product_id'] . '_attendeelastname_' . $x]) {

                        $notice = sprintf(__('Last name is required for %s attendee %d', 'woocommerce-events'), $event, $x);
                        wc_add_notice($notice, 'error');

                    }

                    if (!$_POST[$ticket['product_id'] . '_attendeeemail_' . $x]) {

                        $notice = sprintf(__('Email is required for %s attendee %d', 'woocommerce-events'), $event, $x);
                        wc_add_notice($notice, 'error');

                    }

                    if ($WooCommerceEventsCaptureAttendeeTelephone === 'on') {
                        if (!$_POST[$ticket['product_id'] . '_attendeetelephone_' . $x]) {

                            $notice = sprintf(__('Telephone is required for %s attendee %d', 'woocommerce-events'), $event, $x);
                            wc_add_notice($notice, 'error');

                        }
                    }

                    if ($WooCommerceEventsCaptureAttendeeCompany === 'on') {
                        if (!$_POST[$ticket['product_id'] . '_attendeecompany_' . $x]) {

                            $notice = sprintf(__('Company is required for %s attendee %d', 'woocommerce-events'), $event, $x);
                            wc_add_notice($notice, 'error');

                        }
                    }

                    if ($WooCommerceEventsCaptureAttendeeDesignation === 'on') {
                        if (!$_POST[$ticket['product_id'] . '_attendeedesignation_' . $x]) {

                            $notice = sprintf(__('Designation is required for %s attendee %d', 'woocommerce-events'), $event, $x);
                            wc_add_notice($notice, 'error');

                        }
                    }

                    if (!$this->is_email_valid($_POST[$ticket['product_id'] . '_attendeeemail_' . $x])) {

                        $notice = sprintf(__('Email is not valid for %s attendee %d', 'woocommerce-events'), $event, $x);
                        wc_add_notice($notice, 'error');

                    }

                    if (!function_exists('is_plugin_active_for_network')) {

                        require_once(ABSPATH . '/wp-admin/includes/plugin.php');

                    }

                    if ($this->is_plugin_active('fooevents_custom_attendee_fields/fooevents-custom-attendee-fields.php') || is_plugin_active_for_network('fooevents_custom_attendee_fields/fooevents-custom-attendee-fields.php')) {

                        $Fooevents_Custom_Attendee_Fields = new Fooevents_Custom_Attendee_Fields();
                        $Fooevents_Custom_Attendee_Fields->check_required_fields($ticket, $event, $x);


                    }

                }

                $x++;

            }

        }

    }

    /**
     * Creates tickets and assigns attendees
     *
     */
    public function woocommerce_events_process($order)
    {
        if (true === WP_DEBUG) {
            error_log('test order id' . $order->get_id());
        }

        $order_id = $order->get_id();

        set_time_limit(0);

        global $woocommerce;

        $events = $this->get_order_events($woocommerce);

        /*echo "<pre>";
            print_r($events);
        echo "</pre>";
        echo "<pre>";
            print_r($_POST);
        echo "</pre>";

        exit();*/

        $totalTickets = array();
        foreach ($events as $event => $tickets) {

            $x = 1;
            foreach ($tickets as $ticket) {

                $WooCommerceEventsCaptureAttendeeDetails = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeDetails', true);
                $WooCommerceEventsCaptureAttendeeTelephone = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeTelephone', true);
                $WooCommerceEventsCaptureAttendeeCompany = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeCompany', true);
                $WooCommerceEventsCaptureAttendeeDesignation = get_post_meta($ticket['product_id'], 'WooCommerceEventsCaptureAttendeeDesignation', true);

                $customer = get_post_meta($order_id, '_customer_user', true);

                $customerDetails = array(
                    'customerID' => $customer
                );

                if (empty($customerDetails['customerID'])) {

                    $customerDetails['customerID'] = 0;

                }

                if (empty($ticket['variations'])) {

                    $ticket['variations'] = '';

                }

                if ($WooCommerceEventsCaptureAttendeeDetails === 'on') {

                    $attendeeName = $_POST[$ticket['product_id'] . '_attendee_' . $x];
                    $attendeeLastName = $_POST[$ticket['product_id'] . '_attendeelastname_' . $x];
                    $attendeeEmail = $_POST[$ticket['product_id'] . '_attendeeemail_' . $x];
                    $attendeeTelephone = '';
                    $attendeeCompany = '';
                    $attendeeDesignation = '';

                    if ($WooCommerceEventsCaptureAttendeeTelephone === 'on') {
                        $attendeeTelephone = $_POST[$ticket['product_id'] . '_attendeetelephone_' . $x];
                    }

                    if ($WooCommerceEventsCaptureAttendeeCompany === 'on') {
                        $attendeeCompany = $_POST[$ticket['product_id'] . '_attendeecompany_' . $x];
                    }

                    if ($WooCommerceEventsCaptureAttendeeDesignation === 'on') {
                        $attendeeDesignation = $_POST[$ticket['product_id'] . '_attendeedesignation_' . $x];
                    }

                    if (empty($ticket['variation_id'])) {

                        $ticket['variation_id'] = '';

                    }

                    //create ticket
                    $ticket['WooCommerceEventsTicketID'] = $this->create_ticket($customerDetails['customerID'], $ticket['product_id'], $order_id, $ticket['attribute_ticket-type'], $ticket['variations'], $ticket['variation_id'], $x, $attendeeName, $attendeeLastName, $attendeeEmail, $attendeeTelephone, $attendeeCompany, $attendeeDesignation);

                } else {

                    if (empty($ticket['variation_id'])) {

                        $ticket['variation_id'] = '';

                    }

                    $ticket['WooCommerceEventsTicketID'] = $this->create_ticket($customerDetails['customerID'], $ticket['product_id'], $order_id, $ticket['attribute_ticket-type'], $ticket['variations'], $ticket['variation_id'], $x);

                }

                $x++;
                //$totalTickets++;

                if (empty($ticket['product_id'])) {

                    $totalTickets[$ticket['product_id']] = 1;

                } else {

                    if (isset($totalTickets[$ticket['product_id']])) {

                        $totalTickets[$ticket['product_id']]++;

                    } else {

                        $totalTickets[$ticket['product_id']] = 1;

                    }

                }

            }


        }

        update_post_meta($order_id, 'WooCommerceEventsTicketsPurchased', json_encode($totalTickets));
        //exit();

    }

    /**
     * Checks a string for valid email address
     *
     * @param string $email
     * @return bool
     */
    private function is_email_valid($email)
    {

        return filter_var($email, FILTER_VALIDATE_EMAIL)
            && preg_match('/@.+\./', $email);

    }

    private function get_order_events($woocommerce)
    {
        $products = $woocommerce->cart->get_cart();

        $events = array();
        foreach ($products as $cart_item_key => $product) {

            for ($x = 0; $x < $product['quantity']; $x++) {

                $WooCommerceEventsEvent = get_post_meta($product['product_id'], 'WooCommerceEventsEvent', true);

                if ($WooCommerceEventsEvent == 'Event') {

                    $product_data = get_post($product['product_id']);

                    $ticket = array();
                    $ticket['product_id'] = $product['product_id'];
                    $ticket['attribute_ticket-type'] = '';
                    $ticket['event_name'] = $product_data->post_title;

                    if (!empty($product['variation']['attribute_ticket-type'])) {

                        $ticket['attribute_ticket-type'] = $product['variation']['attribute_ticket-type'];

                    }


                    if (!empty($product['variation'])) {

                        $ticket['variations'] = $product['variation'];
                        $ticket['variation_id'] = $product['variation_id'];

                    }

                    $events[$product_data->post_title][] = $ticket;

                }

            }

        }

        return $events;

    }

    /**
     * Creates a new ticket
     *
     */
    public function create_ticket($customerID, $product_id, $order_id, $ticketType, $variations, $variationID, $x, $attendeeName = '', $attendeeLastName = '', $attendeeEmail = '', $attendeeTelephone = '', $attendeeCompany = '', $attendeeDesignation = '')
    {

        $order = new WC_Order($order_id);

        $rand = rand(111111, 999999);

        $post = array(

            'post_author' => $customerID,
            'post_content' => "Ticket",
            'post_status' => "publish",
            'post_title' => 'Assigned Ticket',
            'post_type' => "event_magic_tickets"

        );

        $post['ID'] = wp_insert_post($post);
        $ticketID = $post['ID'] . $rand;
        $post['post_title'] = '#' . $ticketID;
        $postID = wp_update_post($post);


        $variations = json_encode($variations, JSON_UNESCAPED_UNICODE);

        update_post_meta($postID, 'WooCommerceEventsTicketID', $ticketID);
        update_post_meta($postID, 'WooCommerceEventsProductID', $product_id);
        update_post_meta($postID, 'WooCommerceEventsOrderID', $order_id);
        update_post_meta($postID, 'WooCommerceEventsTicketType', $ticketType);
        update_post_meta($postID, 'WooCommerceEventsStatus', 'Unpaid');
        update_post_meta($postID, 'WooCommerceEventsCustomerID', $customerID);
        update_post_meta($postID, 'WooCommerceEventsAttendeeName', $attendeeName);
        update_post_meta($postID, 'WooCommerceEventsAttendeeLastName', $attendeeLastName);
        update_post_meta($postID, 'WooCommerceEventsAttendeeEmail', $attendeeEmail);
        update_post_meta($postID, 'WooCommerceEventsAttendeeTelephone', $attendeeTelephone);
        update_post_meta($postID, 'WooCommerceEventsAttendeeCompany', $attendeeCompany);
        update_post_meta($postID, 'WooCommerceEventsAttendeeDesignation', $attendeeDesignation);
        update_post_meta($postID, 'WooCommerceEventsVariations', $variations);
        update_post_meta($postID, 'WooCommerceEventsVariationID', $variationID);
        update_post_meta($postID, 'WooCommerceEventsPurchaserFirstName', $order->billing_first_name);
        update_post_meta($postID, 'WooCommerceEventsPurchaserLastName', $order->billing_last_name);
        update_post_meta($postID, 'WooCommerceEventsPurchaserEmail', $order->billing_email);

        $product = get_post($product_id);

        update_post_meta($postID, 'WooCommerceEventsProductName', $product->post_title);

        if (!function_exists('is_plugin_active_for_network')) {

            require_once(ABSPATH . '/wp-admin/includes/plugin.php');

        }

        if ($this->is_plugin_active('fooevents_custom_attendee_fields/fooevents-custom-attendee-fields.php') || is_plugin_active_for_network('fooevents_custom_attendee_fields/fooevents-custom-attendee-fields.php')) {

            $Fooevents_Custom_Attendee_Fields = new Fooevents_Custom_Attendee_Fields();
            $Fooevents_Custom_Attendee_Fields->capture_custom_attendee_options($postID, $product_id, $x);

        }

        return $ticketID;

    }

    private function is_plugin_active($plugin)
    {

        return in_array($plugin, (array)get_option('active_plugins', array()));

    }

}
