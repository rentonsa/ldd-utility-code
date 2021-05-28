import csv
csvfileout = open('material_fix.csv', 'w')
writer = csv.writer(csvfileout,delimiter=',',quotechar='"')

MAT = open('art_materials.csv', 'r')
MAT_LIST= csv.DictReader(MAT, delimiter=',')
MAT_ARRAY = list(MAT_LIST)
MAT_LEN = len(MAT_ARRAY)

OUT_ARRAY = []

mat_row = 0

while mat_row < MAT_LEN:
    mat_id = str(MAT_ARRAY[mat_row]['\ufeffid']).strip()
    print(mat_id)
    mat_val = str(MAT_ARRAY[mat_row]['value']).strip()
    print(mat_val)
    out_row = 0
    mat_id_found = False
    OUT_LEN = len(OUT_ARRAY)
    print(OUT_LEN)

    while out_row < OUT_LEN:
        print("in here")
        print("ID" + OUT_ARRAY[out_row]['id'])
        if mat_id in OUT_ARRAY[out_row]['id']:
            print("match")
            OUT_ARRAY[out_row]['value'] = OUT_ARRAY[out_row]['value'] + "||" + mat_val
            print(OUT_ARRAY[out_row])
            mat_id_found = True
        out_row += 1
    if not mat_id_found:
        print("not_found")
        new_data = {"id": mat_id, "value": mat_val}
        print(new_data)
        OUT_ARRAY.append(new_data)
        print(OUT_ARRAY)
        out_row += 1
    mat_row += 1

# Open File
# Write data to file
for r in OUT_ARRAY:
    csvfileout.write(str(r['id']) + ","+ str(r['value']) + "\n")
csvfileout.close()
