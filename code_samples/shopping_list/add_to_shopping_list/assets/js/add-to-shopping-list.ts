// Shopping list service
import ShoppingList from '@ibexa-shopping-list/src/bundle/Resources/public/js/component/shopping.list';
// The Add to shopping list interaction
import { AddToShoppingList } from '@ibexa-shopping-list/src/bundle/Resources/public/js/component/add.to.shopping.list';
// List of all user's shopping lists
import { ShoppingListsList } from '@ibexa-shopping-list/src/bundle/Resources/public/js/component/shopping.lists.list';

(function (global: Window, doc: Document) {
    const shoppingList = new ShoppingList();
    shoppingList.init(); // Fetch user's shopping lists

    const addToShoppingListsNodes = doc.querySelectorAll<HTMLDivElement>('.ibexa-sl-add-to-shopping-list');
    addToShoppingListsNodes.forEach((addToShoppingListNode) => {
        const addToShoppingList = new AddToShoppingList({ node: addToShoppingListNode, ListClass: ShoppingListsList });

        addToShoppingList.init();
    });
})(window, window.document);
