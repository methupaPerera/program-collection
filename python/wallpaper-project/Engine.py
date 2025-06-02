from threading import Thread
import requests
import json
import time
import ctypes
import os

class Engine(Thread):
    def __init__(self, url):
        super().__init__()
        self.url = url

    def __getWeatherInfo(self):
        response = requests.get(self.url)

        if response.status_code == 200:
            return json.loads(response.content)["weather"][0]
    
    def run(self):
        print("Please wait...")

        while True:
            data = self.__getWeatherInfo()["description"]

            if data:
                response = requests.get(f"https://unsplash.com/napi/search/photos?page=1&query={data}&per_page=1")
                image_link = (json.loads(response.content))["results"][0]["urls"]["raw"]
                print(image_link)

                image = requests.get(image_link).content

                with open("img.jpg", "wb") as img:
                    img.write(image)
                
                wallpaper_path = 'img.jpg'
                current_directory = os.getcwd()
                file_path = os.path.join(current_directory, wallpaper_path)

                SPI_SETDESKWALLPAPER = 20

                ctypes.windll.user32.SystemParametersInfoW(SPI_SETDESKWALLPAPER, 0, file_path, 6)
            else:
                print("Something went wrong!")
                time.sleep(60)