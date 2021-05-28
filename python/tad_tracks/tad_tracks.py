import csv
csvfileout = open('track_better.csv', 'w')
writer = csv.writer(csvfileout,delimiter=',',quotechar='"')



TAPE = open('tapes.csv', 'r')
TAPE_LIST= csv.DictReader(TAPE, delimiter=',')
TAPE_ARRAY = list(TAPE_LIST)
TAPE_LEN = len(TAPE_ARRAY)

TRACK = open('tracks.csv', 'r')
TRACK_LIST= csv.DictReader(TRACK, delimiter=',')
TRACK_ARRAY = list(TRACK_LIST)
TRACK_LEN = len(TRACK_ARRAY)

track_row = 0

while track_row < TRACK_LEN:
    track_id = str(TRACK_ARRAY[track_row]['\ufeffid']).strip()
    comp_id = str(TRACK_ARRAY[track_row]['component_id']).strip()
    create_time = str(TRACK_ARRAY[track_row]['create_time']).strip()
    title = str(TRACK_ARRAY[track_row]['title']).strip()
    parent_id = str(TRACK_ARRAY[track_row][' parent_id']).strip()
    tape_row = 0
    while tape_row < TAPE_LEN:
        if str(TAPE_ARRAY[tape_row]['\ufeffid']) == str(parent_id):
            tape_name = str(TAPE_ARRAY[tape_row]['title']).strip()
            series_id = str(TAPE_ARRAY[tape_row][' parent_id']).strip()

            switcher = {
                "161692": "SSS",
                "161693": "BBC",
                "161694": "Canna"
            }
            series_name = switcher.get(series_id, "invalid id")
            series_name.strip()
            writer.writerow([track_id, comp_id, create_time, title, tape_name, parent_id, series_name])
        tape_row +=1


    track_row +=1
    print(track_row)