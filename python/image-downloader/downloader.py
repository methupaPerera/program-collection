from multiprocessing import Process
import requests

class Downloader(Process):
    def __init__(self, id, urls, result):
        super().__init__()

        self.id = id
        self.urls = urls
        self.count = 0
        self.result = result

    def download(self, url, image_number):
        response = requests.get(url=url)

        if response.status_code == 200:
            data = response.content
            file = f"images/image_{str(self.id) + str(image_number)}.jpg"

            with open(file, "wb") as img:
                img.write(data)
        
            print(f"Image downloaded ! - {file}")
            return True
        else:
            print("File downloading failed !")
            return False
    
    def run(self):
        for i, url in enumerate(self.urls):
            status = self.download(url, i)
            if status == False:
                self.result.put(1)