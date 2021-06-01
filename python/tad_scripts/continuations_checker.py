import requests
import json
import csv
import os
import logging

logging.basicConfig(filename='subject_fix.log',level=logging.DEBUG)

# Script currently adds a repository processing note based on two column TSV input file where column 1 contains the component ref_id and column 2 contains the text of the note

# This was written under the assumption that you might have a csv (or similar), exported from ASpace or
# compiled from an ASpace exported EAD, with an existing archival object's ref_id. Using only the ref_id,
# this will use the ASpace API to search for the existing archival object, retrieve its URI, store the archival
# object's JSON, and supply a new repository_processing_note for the archival object (supplied in the input CSV),
# The script will then repost the archival object to ASpace using the update archival object endpoint

# The 2 column CSV should look like this (without a header row):
# [ASpace ref_id],[repo_processing_note]

# The archival_object_csv will be your starting TSV (as .txt) with the ASpace ref_id of the archival object's to be updated,
archival_object_csv = os.path.normpath("continuation_base.csv")

# The updated_archival_object_csv will be an updated csv that will be created at the end of this script, containing all of the same
# information as the starting csv, plus the ArchivesSpace URIs for the updated archival objects
updated_archival_object_csv = os.path.normpath("subjects_out.csv")

# Modify your ArchivesSpace backend url, username, and password as necessary
aspace_url = 'http://lac-archivesspace-live2.is.ed.ac.uk:8089'  # Backend URL for ASpace
username = 'admin'

password = 'xxxxxxx'
# Login to ASpace backend and store the session token and some header info
auth = requests.post(aspace_url + '/users/' + username + '/login?password=' + password).json()
session = auth["session"]
headers = {'X-ArchivesSpace-Session': session}

logging.info(session)

# Open the CSV file and iterate through each row
with open(archival_object_csv, 'r') as csvfile:
    reader = csv.reader(csvfile)
    n = 0
    ok = 0
    for row in reader:
        n += 1
        # Grab the archival object's ArchivesSpace ref_id from the CSV
        component_id = row[0]  # column 1
        logging.info("ROW: " + str(n) + " COMPONENT " + str(component_id))

        # Use the find_by_id endpoint (only availble in v1.5+) to  use the ref_ID in the CSV to retrieve the archival object's URI
        #params = {"component_id[]": component_id}
        #print(params)
        #lookup = requests.get(aspace_url + '/repositories/2/find_by_id/archival_objects', headers=headers,
                              #params=params).json()
        #print(lookup)
        # Grab the archival object uri from the search results
        #archival_object_uri = lookup['archival_objects'][0]['ref']
        archival_object_uri = '/repositories/2/archival_objects/' + component_id
        logging.info('Archival Object: ' + archival_object_uri)

        # Submit a get request for the archival object and store the JSON
        archival_object_json = requests.get(aspace_url + archival_object_uri, headers=headers).json()

        # print the JSON reponse to see structure and figure out where you might want to add other notes or metadata values, etc.
        #print(archival_object_json)

        # Continue only if the search-returned archival object's ref_id matches our starting ref_id, just to be safe
        if archival_object_json['component_id'] == component_id:
            # Add the archival object uri to the row from the CSV to write it out at the end
            for each note = archival_object_json['notes']
            if "Next track in chain" in note:


            logging.info("OK. Added " + str(subject_ref) + "to track " + str(component_id))

            '\n'
    logging.info("SUBJECTS ADDED " + str(ok) + " out of " + str(n))