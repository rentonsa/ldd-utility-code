import requests
import json
import logging
import os
from pprint import pprint
from pathlib import Path
from csv import DictReader
from itertools import groupby
from operator import itemgetter
from collections import ChainMap

# Specify the log file
logging.basicConfig(filename='note_upload.log',level=logging.DEBUG)

# Specify the Path to the csv
csv_path = "notes.csv"


headers = {
    'Content-Type': 'application/json', 'Accept': 'application/json'
}


# Login to ArchivesSpace and return SessionID

as_base_url = "http://lac-archivesspace-live1.is.ed.ac.uk"
as_user = input("Enter your ArchivesSpace username:")
as_password = input("Enter your ArchivesSpace password:")
as_archival_repo = "2"
as_url_port = "8089"


def load_note_info():
    with open(csv_path) as read_obj:
        note_info = DictReader(read_obj)
        note_info_list = list(note_info)
        for info in note_info_list:
            #info['id'] = info.pop('\ufeffContributor ID')
            info['id'] = info.pop('id')
            info['id'] = int(info['id'])
        return note_info_list


def as_login():
    files = {
        'password': (None, as_password),
    }
    response = requests.post(f"{as_base_url}:{as_url_port}/users/{as_user}/login", files=files)
    return response.json()['session']


# Todo: has to be changed to link image to the agent in AS which has the same number as the folder number of the image
def get_as_track(as_base_url, as_url_port, as_session_id, track_id): #use image_id as agent_id as they are the same- NOT IN TEST!
    link_to_track = f'{as_base_url}:{as_url_port}/repositories/2/archival_objects/{track_id}'
    pprint(link_to_track)
    as_headers = {
        'X-ArchivesSpace-Session': as_session_id
    }
    response = requests.get(link_to_track, as_headers)
    print(response)
    as_track = response.json()
    print(as_track)

    return as_track

def update_as_track(as_base_url, as_url_port, as_session_id, track_id, as_track, note_type,note_label, note_text):
    link_to_track = f'{as_base_url}:{as_url_port}/repositories/2/archival_objects/{track_id}'
    as_headers = {
        'X-ArchivesSpace-Session': as_session_id
    }
    as_track['notes'].append({'jsonmodel_type': 'note_multipart','publish': False,
                              'subnotes': [
                                  {'content': note_text, 'jsonmodel_type': 'note_text', 'type': note_type, 'publish': False}]})
    response = requests.post(link_to_track, headers=as_headers, data=json.dumps(as_track))
    print(response.status_code)



def main():
    note_info = load_note_info()
    print(note_info)
    as_session_id = as_login()
    # merge the list of dicts in image_info with the one in image_list
    #grouped_images = groupby(sorted(image_info + image_list, key=itemgetter("id")), itemgetter("id"))
    #images = [dict(ChainMap(*g)) for k, g in grouped_images]
    # iterate over the images-test reformat the information to apply to DSpace
    for note in note_info:
         if "type" in note and "id" in note and "text" in note:
             as_track = get_as_track(as_base_url, as_url_port, as_session_id, note['id'])
             # update the as agent with the desired link info
             print(as_track)
             if "text" in as_track and as_track['text']:
                 print(as_track)
                 update_as_track(as_base_url, as_url_port, as_session_id, note['id'], as_track,
                                 note['type'], note['label'], note['text'])
                 pprint(f" the image with the id: {note['id']} the type: {note['name']} and the value: {note['text']} has been uploaded to {as_track}")
             else:
                 pprint(f"The Agent with the id {note['id']} is not in ArchivesSpace or {as_track} has no label")

         else:
             pprint(f"{note['id']} has not all necessary parameters")


main()
