from downloader import Downloader
import time
from multiprocessing import Queue

def urlGenerator(count):
    for i in range(0, count):
        yield f"https://picsum.photos/id/{i}/200/300"
    
group_count = 10

def url_grouper(urls, groups):
    url_groups = []

    for i in range(0, len(urls), groups):
        l = urls[i : i + groups]
        url_groups.append(l)

    return url_groups

url_groups = url_grouper(list(urlGenerator(100)), group_count)

if __name__ == "__main__":
    start = time.time_ns()

    result = Queue()
    threads = []

    for i, url_group in enumerate(url_groups):
        thread = Downloader(i, url_group, result)
        thread.start()
        threads.append(thread)
        
    for thread in threads:
        thread.join()

    total = 0
    while not result.empty():
        total += result.get()

    diff = time.time_ns() - start

    print(f"Download completed in {diff/1000000000} seconds.")
    print(f"Failed to download {total} of {len(url_groups)*group_count} images")