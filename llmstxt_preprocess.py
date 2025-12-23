from typing import TYPE_CHECKING

if TYPE_CHECKING:
    from bs4 import BeautifulSoup


def preprocess(soup: "BeautifulSoup", output: str) -> None:
    """
    Preprocess HTML to improve markdown conversion.
    
    Converts card macro HTML structure into markdown lists with links
    so they are preserved in the llms.txt output.
    """
    # Find all cards wrapper divs (these contain groups of cards)
    cards_divs = soup.find_all("div", class_=lambda c: c and c.startswith("cards "))
    
    for cards_div in cards_divs:
        # Find all card-wrapper divs within this cards group
        card_wrappers = cards_div.find_all("div", class_="card-wrapper")
        
        if not card_wrappers:
            continue
        
        # Create a list to hold all the cards in this group
        ul = soup.new_tag("ul")
        
        for card_wrapper in card_wrappers:
            # Extract the link, title, and description from the card structure
            link = card_wrapper.find("a", class_="card")
            if not link:
                continue
                
            href = link.get("href", "")
            # Fix protocol-relative URLs
            if href.startswith("//"):
                href = "https:" + href
            
            title_elem = link.find("p", class_="title")
            description_elem = link.find("p", class_="description")
            
            if not title_elem:
                continue
                
            title = title_elem.get_text(strip=True)
            description = description_elem.get_text(strip=True) if description_elem else ""
            
            # Create a list item with a link and description
            li = soup.new_tag("li")
            link_tag = soup.new_tag("a", href=href)
            link_tag.string = title
            li.append(link_tag)
            
            if description:
                li.append(soup.new_string(" - "))
                li.append(soup.new_string(description))
            
            ul.append(li)
        
        # Replace the entire cards div with the unordered list
        cards_div.replace_with(ul)
