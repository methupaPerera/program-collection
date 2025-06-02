from Engine import Engine

if __name__ == "__main__":
     city = input("Please enter the name of the city - ")
     url = f"https://api.openweathermap.org/data/2.5/weather?q={city}&appid=712b5072e3d063a04db1ccb3432ff551"

     engine = Engine(url)
     engine.start()
     engine.join()
