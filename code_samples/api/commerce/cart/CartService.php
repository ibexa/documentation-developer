<?php

$cart = $this->cartService->getCart('20298efa-c18d-45c5-9fea-24770a54a637');

$output->writeln($cart->getName());

***

use Ibexa\Contracts\Cart\Value\CartQuery;

// ...

$cartQuery = new CartQuery();
$cartQuery->setOwnerId(123); // carts created by User ID: 123
$cartQuery->setLimit(20); // fetch 20 carts

$cartsList = $this->cartService->findCarts($cartQuery);

$cartsList->getCarts(); // array of CartInterface objects
$cartsList->getTotalCount(); // number of returned carts

***

use Ibexa\Contracts\Cart\Value\CartCreateStruct;

// ...

$cartCreateStruct = new CartCreateStruct(
    'Default cart',
    $currency // Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface  
);

$cart = $this->cartService->createCart($cartCreateStruct);

$output->writeln($cart->getName()); // prints 'Default cart' to the console

***

use Ibexa\Contracts\Cart\Value\CartMetadataUpdateStruct;

// ...

$cartUpdateMetadataStruct = new \Ibexa\Contracts\Cart\Value\CartMetadataUpdateStruct();
$cartUpdateMetadataStruct->setName('New name');
$cartUpdateMetadataStruct->setCurrency($newCurrency);

$updatedCart = $this->cartService->updateCartMetadata($cart, $cartUpdateMetadataStruct);

$output->writeln($updatedCart->getName()); // prints 'New name' to the console

***

// load the cart first
$cart = $this->cartService->getCart('20298efa-c18d-45c5-9fea-24770a54a637');

// delete it permanently
$this->cartService->deleteCart($cart);

***

// load the cart first
$cart = $this->cartService->getCart('20298efa-c18d-45c5-9fea-24770a54a637');

// empty it
$this->cartService->emptyCart($cart);

***

// load the cart first
$cart = $this->cartService->getCart('20298efa-c18d-45c5-9fea-24770a54a637');

$violationList = $this->cartService->validateCart($cart); // Symfony\Component\Validator\ConstraintViolationListInterface

***

use Ibexa\Contracts\Cart\Value\EntryAddStruct;

// ...

// load the cart first
$cart = $this->cartService->getCart('20298efa-c18d-45c5-9fea-24770a54a637');

$entryAddStruct = new EntryAddStruct();
$entryAddStruct->setProduct(
    $product, // Ibexa\Contracts\ProductCatalog\Values\ProductInterface
);
$entryAddStruct->setQuantity(10);

$cart = $this->cartService->addEntry($cart, $entryAddStruct);

$entry = $cart->getEntries()->first();
$output->writeln($entry->getProduct()->getName()); // prints product name to the console

***

use Ibexa\Contracts\Cart\Value\EntryAddStruct;

// ...

// load the cart first
$cart = $this->cartService->getCart('20298efa-c18d-45c5-9fea-24770a54a637');

// find an entry to be removed from the cart
$entry = $cart->getEntries()->first();

$cart = $this->cartService->removeEntry($cart, $entry); // updated Cart object

***

use Ibexa\Contracts\Cart\Value\EntryUpdateStruct;

// ...

// load the cart first
$cart = $this->cartService->getCart('20298efa-c18d-45c5-9fea-24770a54a637');

// find entry you would like to remove from cart
$entry = $cart->getEntries()->first();

$entryUpdateStruct = new EntryUpdateStruct();
$entryUpdateStruct->setQuantity(5);

$cart = $this->cartService->updateEntry(
        $cart, 
        $entry,
        $entryUpdateStruct
); // updated Cart object
