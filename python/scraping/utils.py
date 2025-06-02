def queueToList(queue):
    list = []

    while not queue.empty():
        list.append(queue.get())
    
    return list