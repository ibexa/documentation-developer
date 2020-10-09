# SummaryCheckoutFormService

`SummaryCheckoutFormService` (`Siso\Bundle\CheckoutBundle\Service\SummaryCheckoutFormService`) implements the logic for the `CheckoutSummary` form.
This service is assigned to the `CheckoutSummary` form in the [configuration](../configuration_for_checkout_forms.md).

This service implements [`CheckoutFormServiceInterface`](interfaces_for_checkout_services.md#checkoutformserviceinterface) and  [`CheckoutSummaryFormServiceInterface`](interfaces_for_checkout_services.md#checkoutsummaryformserviceinterface).

The service ID is `siso_checkout.checkout_form.summary`.

## Usage

**Example**

``` php
$formService = $this->container->get('siso_checkout.checkout_form.summary');
/** @var BasketService $basketService */
$basketService = $this->container->get('silver_basket.basket_service');
$basket = $basketService->getBasket($request);
  
$form = $this->handleForm($request, $data, $basket);
if ($form->isValid()) {
    if ($form->getViewData()->hasChanged()){
       $formService->storeFormDataInBasket($form->getViewData(), $basket);
    }
}
```

## Comment limit

In the summary there is a comment field that the user can fill in.

By default, the comment box does not have a limit, but it is possible to configure a limit for it in `CheckoutBundle/Resources/config/checkout.yml`:

``` yaml
siso_checkout.default.checkout_form_summary_max_length: 30
```

The mapping of the request order should be modified to unlimit the number of characters:

`EshopBundle/Resources/mapping/wc3-nav/xsl/include/request.order.xsl`:

``` xml
    <xsl:if test="$message_type != 'calculate'">
        <Comment_Lines singleElementArrays="Comment_Line">
            <xsl:call-template name="comments" >
                <xsl:with-param name="separator" />
                </xsl:call-template>
        </Comment_Lines>  
    </xsl:if> 

<xsl:template name="comments">
    <xsl:param name="separator" select="'||'" />
    <xsl:param name="text" select="SesExtension/Remark" />
    <xsl:choose>
        <xsl:when test="not(contains($text, $separator))">
            <Comment_Line>
                <Comment>
                    <xsl:value-of select="normalize-space($text)"/>
                </Comment>
            </Comment_Line>
        </xsl:when>
        <xsl:otherwise>
            <Comment_Line>
                <Comment>
                    <xsl:value-of select="normalize-space(substring-before($text, $separator))"/>
                </Comment>
            </Comment_Line>
            <xsl:call-template name="comments">
                <xsl:with-param name="text" select="substring-after($text, $separator)"/>
            </xsl:call-template>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>
```
