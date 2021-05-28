"""
Scott Renton, Mar 2021
OAI ArchivesSpace
"""
import xml.etree.ElementTree as ET
import requests
from variables import ALL_VARS

def control():
    """
    action- process DC first, and then Edinburgh
    """
    #get urls
    url_list = ALL_VARS['EAD_URL_LIST']
    url_list_len = len(url_list)
    print('LEN'+str(url_list_len))
    #for each URL, estanblish metadata format and institution

    rtoken = ''
    times_round = 0

    myfile = open("output.xml", "w")
    rtokenfound = True

    while times_round == 0 or rtokenfound or rtoken != '':
        if rtoken == '':
            url = "http://lac-archives-live.is.ed.ac.uk:8082/?verb=ListRecords&metadataPrefix=oai_ead&set=repository_set"
            #url = "http://lac-archives-live.is.ed.ac.uk:8082/?verb=ListRecords&resumptionToken=eyJtZXRhZGF0YV9wcmVmaXgiOiJvYWlfZWFkIiwic2V0IjoicmVwb3NpdG9yeV9zZXQiLCJmcm9tIjoiMTk3MC0wMS0wMSAwMDowMDowMCBVVEMiLCJ1bnRpbCI6IjIwMjEtMDUtMTMgMTQ6MjE6MzMgVVRDIiwic3RhdGUiOiJwcm9kdWNpbmdfcmVjb3JkcyIsImxhc3RfZGVsZXRlX2lkIjowLCJyZW1haW5pbmdfdHlwZXMiOnsiUmVzb3VyY2UiOjg3MDg2fSwiaXNzdWVfdGltZSI6MTYyMDkxNzMyNjIyN30="
            data = get_data(url)
        else:
            if rtokenfound:
                url = "http://lac-archives-live.is.ed.ac.uk:8082/?verb=ListRecords&resumptionToken=" + rtoken
                print('getting data for ' + url)
                data = get_data(url)
                rtokenfound = False
            else:
                print("finished")
                break

        tree = ET.ElementTree(ET.fromstring(data))
        xmlroot = tree.getroot()

        #mydata = ET.tostring(data)
        #an_element = ET.Element("Animal", Species="Python")

        #element_string = ET.tostring(an_element, encoding="unicode")

        myfile.write(data)

        for item in xmlroot.iterfind(".//"):
        #     if "header" in item.tag:
        #         if "status" in item.attrib:
        #            print(item.attrib['status'])
        #     if "identifier" in item.tag:
        #          print(item.text)
        #     if "c01" in item.tag:
        #         for coichild in item:
        #             if "did" in coichild.tag:
        #                 print(item.attrib['id'].replace("A_", ""))
              if "resumptionToken" in item.tag:
                  rtoken = item.text
                  rtokenfound = True
                  print(rtoken)
        #     print(item)
        times_round += 1

        print(times_round)

    print("finished")

def get_data(url):
    """
    populate variables with oai responses
    """
    response = requests.get(url)
    data = response.text
    return data

control()
