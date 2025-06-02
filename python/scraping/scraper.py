from bs4 import BeautifulSoup
import requests
from threading import Thread
from queue import Queue
from utils import queueToList
import json

current_page = 1
pages_to_scrape = 20

book_data = Queue()

class Scraper(Thread):
    def __init__(self, page):
        super().__init__()
        self.page = page

    def run(self):
        url = f"https://books.toscrape.com/catalogue/page-{self.page}.html"
        html = requests.get(url)
        soup = BeautifulSoup(html.text, "html.parser")

        books = soup.find_all("article", class_="product_pod")

        for index, book in enumerate(books):
            name = book.find("h3").find("a").get("title").strip()
            price = (book.find("div", class_="product_price").find_all("p")[0].text.strip())
            in_stock = (book.find("div", class_="product_price").find_all("p")[1].text.strip())
            rating = book.find("p", class_="star-rating").get("class")[1]

            book_data.put({"name": name, "price": price, "in_stock": in_stock, "rating": rating})

threads = []

for i in range(pages_to_scrape):
    scrape = Scraper(page=i+1)
    scrape.start()
    threads.append(scrape)

for thread in threads:
    thread.join()

data = queueToList(book_data)

with open("data.json", "w") as file:
    json.dump(data, file, indent=4)