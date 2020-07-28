"""
# Scott Renton, Jul 2020
# Mets- LUNA mapper triggered by goobi
"""

#global variable definition, general setup
import os
import csv
import argparse
from datetime import timedelta, date
from goobi_mets_luna_variables import ALL_VARS

COLLECTION = ''
ENVIRONMENT = ''
FILTERED = ''
DAYS = ''

PARSER = argparse.ArgumentParser()

PARSER.add_argument('-c', '--collection', action="store", dest="collection", help="collection loading", default="art")
PARSER.add_argument('-e', '--environment', action="store", dest="environment", help="environment- test or live", default="live")
PARSER.add_argument('-d', '--days', action="store", dest="days", help="number of days", default="180")

ARGS = PARSER.parse_args()

print(ARGS)
COLLECTION = str(ARGS.collection)
ENVIRONMENT = str(ARGS.environment)
DAYS = str(ARGS.days)

print('collection is ' + COLLECTION)
print('environment is ' + ENVIRONMENT)
print('days is ' + DAYS)

if ENVIRONMENT == 'live':
    ENVIRONMENT = ''
    WEBENV = ''
else:
    WEBENV = ENVIRONMENT + "."

XML_FILE = open('input.xml')
CSV_FILE = open(ALL_VARS['MAP_FILE_VOL'], 'r')
MAPPING_VOL = csv.DictReader(CSV_FILE, delimiter=':')
MAP_ARRAY = list(MAPPING_VOL)
MAP_LEN = len(MAP_ARRAY)

OUTPUT_FOLDER = COLLECTION
for root, dirs, files in os.walk(OUTPUT_FOLDER):
    for f in files:
        os.unlink(os.path.join(root, f))

if COLLECTION == 'art':
    QUERY_PARM = ALL_VARS['ART_QUERY']

if COLLECTION == 'mimed':
    QUERY_PARM = ALL_VARS['MIMED_QUERY']

DATE_PERIOD = "days"
START_DATE = date.today() - timedelta(**{DATE_PERIOD: int(DAYS)})
DATE_FORMATTED = START_DATE.strftime("%d %m %Y")
DATE_FORMATTED = DATE_FORMATTED.replace(" ", "%20")

QUERY = '(' + QUERY_PARM

URL = ALL_VARS['API_URL'] + QUERY +  ALL_VARS['FIELDS'] +  ALL_VARS['LIMIT']

from xml.etree import cElementTree as ElementTree


def parser(data, tags):
    tree = ElementTree.iterparse(data)

    for event, node in tree:
        if node.tag in tags:
            yield node.tag, node.text, node.attrib

def write_md_to_file(out_file, ET, root):
    """
    Write the XML tree to the dublin core file
    :param out_file: dublin core file
    :param et_out: XML tree in
    :param outroot: dublin core header
    :return: no return
    """
    from xml.dom import minidom
    rough_string = ET.tostring(root, 'utf-8')
    reparsed = minidom.parseString(rough_string)
    pretty_string = reparsed.toprettyxml(indent="\t")
    import codecs
    with codecs.open(out_file, "w", encoding='utf-8') as file:
        file.write(pretty_string)
    file.close()

def main():
    import xml.etree.ElementTree as ET

    tree = ET.parse(XML_FILE)

    root = tree.getroot()

    out_array = []
    for item in root.findall(".//"):
        if item.tag == '{http://www.loc.gov/METS/}dmdSec':
            try:
                if item.attrib['ID'] == 'DMDLOG_0000':
                    for new_item in item.findall(".//"):
                        if new_item.tag =="{http://meta.goobi.org/v1.5.1/}metadata":
                            map_row = 0
                            while map_row < MAP_LEN:
                                try:
                                    if MAP_ARRAY[map_row]['mets'] == new_item.attrib['name']:
                                        out_array.append({'field_group': str(MAP_ARRAY[map_row]['field_group']),
                                                       'field': str(MAP_ARRAY[map_row]['field']),
                                                       'value': str(new_item.text),
                                                        'order':str(MAP_ARRAY[map_row]['order'])})
                                except Exception:
                                    print('cannot assess')
                                map_row = map_row + 1

            except Exception:
                print("other")

    import operator
    sorted_dict = sorted(out_array, key=lambda x:x['order'])

    '''
    with open('input.xml', 'r') as myFile:
        results = parser(myFile, {'{http://www.loc.gov/METS/}mets','{http://meta.goobi.org/v1.5.1/}metadata'})
        item_row = 0
        for tag, text, attrib in results:
            #print(tag, text, attrib)
            map_row = 0
            while map_row < MAP_LEN:
                try:
                    if MAP_ARRAY[map_row]['mets'] == attrib['name']:
                        out_array.append({'field_group':str(MAP_ARRAY[map_row]['field_group']), 'field':str(MAP_ARRAY[map_row]['field']), 'value':str(text)})

                        item_row = item_row + 1
                except Exception:
                    print('cannot assess')
                map_row = map_row + 1
        item_row = 0
    '''
    files = []
    for item in root.findall(".//"):
        if item.tag == '{http://www.loc.gov/METS/}file':
            #print(item.attrib)
            try:
                file_id = item.attrib['ID']
                file_type = item.attrib['MIMETYPE']
            except Exception:
                print('no such attrib')
            for child in item:
                #print('This is '+str(child.attrib))
                repro_id = child.attrib['{http://www.w3.org/1999/xlink}href']

            files.append({'file_id': str(file_id), 'file_type': str(file_type), 'repro_id':str(repro_id)})

    pages = []
    for page_item in root.findall(".//"):
        if page_item.tag == '{http://www.loc.gov/METS/}div':
            try:
                phys_id = page_item.attrib['ID']
                sequence = page_item.attrib['ORDER']
                page_no = page_item.attrib['ORDERLABEL']
                for page_child in page_item:
                    file_id = page_child.attrib['FILEID']
                pages.append({'phys_id': str(phys_id), 'sequence': str(sequence), 'page_no': str(page_no), 'file_id':str(file_id)})
            except Exception:
                print('other')
        #print(pages)


    import xml.etree.cElementTree as ETOut
    outroot = ETOut.Element("recordList")

    records = 0
    for file in files:
        doc = ETOut.SubElement(outroot, "record")
        set_field_groups = []
        out_count = 0
        for item in sorted_dict:
            field_group = item["field_group"]
            if field_group == 'NA':
                field = ETOut.SubElement(doc, "field")
                field.set("name", item["field"])
                value = ETOut.SubElement(field, "value")
                value.text = item["value"]
            else:
                group_set = False
                for group in set_field_groups:
                    if item["field_group"] == group:
                        print(group)
                        group_set = True
                if not group_set:
                    set_field_groups.append(item["field_group"])
                    field_group = ETOut.SubElement(doc, "entity")
                    field_group.set("name", item["field_group"])
                for entity in doc.findall('./entity'):
                    if entity.attrib['name'] == item["field_group"]:
                            # field_group = root.findall('./entity[@id="' + item["field_group"] +'"')
                        field = ETOut.SubElement(entity, "field")
                        field.set("name", item["field"])
                        value = ETOut.SubElement(field, "value")
                        value.text = item["value"]

        subset_field_group = ETOut.SubElement(doc, "entity")
        subset_field_group.set("name", "Subset")
        subset_field = ETOut.SubElement(subset_field_group, "field")
        subset_field.set("name", "Subset Index")
        subset_value = ETOut.SubElement(subset_field, "value")
        for page in pages:
            if page['file_id'] == file['file_id']:
                subset_value.text = page['page_no']
        subset_field = ETOut.SubElement(subset_field_group, "field")
        subset_field.set("name", "Sequence")
        subset_value = ETOut.SubElement(subset_field, "value")
        for page in pages:
            if page['file_id'] == file['file_id']:
                subset_value.text = page['sequence']

        repro_field_group = ETOut.SubElement(doc, "entity")
        repro_field_group.set("name", "repro_record")
        repro_field = ETOut.SubElement(repro_field_group, "field")
        repro_field.set("name", "repro_record_id")
        repro_value = ETOut.SubElement(repro_field, "value")
        repro_value.text = file['repro_id']

    import time
    time_str = time.strftime("%Y%m%d-%H%M%S")
    out_file = "luna_md.xml"
    write_md_to_file(out_file, ETOut, outroot)

if __name__ == '__main__':
    main()
