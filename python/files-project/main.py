class NotEnoughData(Exception):
    def __init__(self):
        super().__init__("Please input some data to your CSV file!")
        self.error_code = 404

class StudentsGrouper:
    def __init__(self, file):
        try:
            with open(file, "r") as file:
                textLines = file.readlines()

            self.data = textLines[1:]
            if len(self.data) <= 1 : raise NotEnoughData()

            self.groupedBySubject = {}
            self.groupedByName = {}
            self.groupedByClass = {}
            self.groupedByNameTotal = {}
            self.highestMarks = {}
        except (FileNotFoundError, NotEnoughData) as e:
            print(e)
            exit()

    def __getEntries(self, info):
        entries: list = info.split(",")

        group = entries[0].strip()
        name = entries[1].strip()
        subject = entries[2].strip()
        marks = int(entries[3].strip())

        return (group, subject, name, marks)

    def groupBySubject(self):
        for info in self.data:
            group, subject, name, marks = self.__getEntries(info)

            if subject not in self.groupedBySubject:
                self.groupedBySubject[subject] = {}
            
            self.groupedBySubject[subject][name] = marks

        return self.groupedBySubject

    def groupByName(self):
        for info in self.data:
            group, subject, name, marks = self.__getEntries(info)

            if name not in self.groupedByName:
                self.groupedByName[name] = {}

            self.groupedByName[name][subject] = marks

        return self.groupedByName
    
    def groupByClass(self):
        for info in self.data:
            group, subject, name, marks = self.__getEntries(info)

            if group not in self.groupedByClass:
                self.groupedByClass[group] = {}

            if name not in self.groupedByClass[group]:
                self.groupedByClass[group][name] = {}

            self.groupedByClass[group][name][subject] = marks

        return self.groupedByClass
    
    def getTotalMarks(self):
        groupedValue = self.groupByName()

        for name, marks in groupedValue.items():
            sum = 0
            for mark in marks.items():
                sum += mark[1]
            self.groupedByNameTotal[name] = sum

        return self.groupedByNameTotal
    
    def getPlaces(self, output=False):
        totalMarks = self.getTotalMarks()

        places = []
        
        placesList = [(name, mark) for name, mark in totalMarks.items()]
        placesList.sort(key=lambda mark: mark[1], reverse=True)
        
        for index, item in enumerate(placesList):
            places.append(f"{index + 1} - {item[0]} - {item[1]}\n")
        
        if output:
            with open("places.txt", "w") as file:
                for place in places:
                    file.write(place)

        return places

    def maxMarkOfEachSubject(self, output=False):
        groupedValue = self.groupBySubject()

        highestMarks = []

        for subject, marks in groupedValue.items():
            maxName = ""
            maxMark = 0

            for name, mark in marks.items():
                if maxMark < mark:
                    maxMark = mark
                    maxName = name

            highestMarks.append(f"{maxName} has the highest mark {maxMark} in {subject}\n")
        
        if output:
            with open("highest-marks.txt", "w") as file:
                for highestMark in highestMarks:
                    file.write(highestMark)
        return highestMarks           

print(StudentsGrouper("data.txt").groupByClass())