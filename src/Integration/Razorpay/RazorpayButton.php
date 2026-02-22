<?php

namespace ArtifyForm\Integration\Razorpay;

use ArtifyForm\Field\AbstractField;

class RazorpayButton extends AbstractField
{
    private $keyId;
    private $amount;
    private $currency = 'INR';
    private $companyName;
    private $description = '';
    private $image = '';
    private $prefillName = '';
    private $prefillEmail = '';
    private $prefillContact = '';
    private $themeColor = '#4f46e5';
    private $callbackUrl = '';

    public function __construct(string $keyId, int $amountInPaise, string $companyName = 'Payment')
    {
        parent::__construct('razorpay_btn');
        $this->keyId = $keyId;
        $this->amount = $amountInPaise;
        $this->companyName = $companyName;
    }

    public function currency(string $currency) 
    { 
        $this->currency = $currency; 
        return $this; 
    }

    public function description(string $description) 
    { 
        $this->description = $description; 
        return $this; 
    }

    public function image(string $image) 
    { 
        $this->image = $image; 
        return $this; 
    }

    public function callbackUrl(string $url) 
    { 
        $this->callbackUrl = $url; 
        return $this; 
    }

    public function prefill(string $name, string $email, string $contact) 
    {
        $this->prefillName = $name;
        $this->prefillEmail = $email;
        $this->prefillContact = $contact;
        return $this;
    }

    public function theme(string $colorHex) 
    { 
        $this->themeColor = $colorHex; 
        return $this; 
    }

    public function render(): string
    {
        // When using the checkout form, we create a script tag inside our wrapper.
        // Once clicked and successful, Razorpay injects a hidden field with razorpay_payment_id and triggers parent form submission.
        
        $callbackAttr = $this->callbackUrl ? ' data-callback_url="'.htmlspecialchars($this->callbackUrl).'"' : '';

        $html = sprintf(
            '<div class="%s" style="margin-top: 1rem; text-align: center;">
                <script
                    src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="%s"
                    data-amount="%d"
                    data-currency="%s"
                    data-name="%s"
                    data-description="%s"
                    data-image="%s"
                    data-prefill.name="%s"
                    data-prefill.email="%s"
                    data-prefill.contact="%s"
                    data-theme.color="%s"
                    %s
                ></script>
            </div>',
            $this->wrapperClass,
            htmlspecialchars($this->keyId),
            $this->amount,
            htmlspecialchars($this->currency),
            htmlspecialchars($this->companyName),
            htmlspecialchars($this->description),
            htmlspecialchars($this->image),
            htmlspecialchars($this->prefillName),
            htmlspecialchars($this->prefillEmail),
            htmlspecialchars($this->prefillContact),
            htmlspecialchars($this->themeColor),
            $callbackAttr
        );
        
        // Render any overarching element errors/helpers
        $html .= $this->renderError() . $this->renderHelper();
        return $html;
    }
}
