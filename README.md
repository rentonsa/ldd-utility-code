skylight-local
==============

Customisations for University of Edinburgh websites, including the public websites:
- http://collections.ed.ac.uk/
- https://exhibitions.ed.ac.uk/
- http://www.scottishgovernmentyearbooks.ed.ac.uk/
- http://collections.ed.ac.uk/art
- http://collections.ed.ac.uk/mimed
- http://collections.ed.ac.uk/calendars
- http://collections.ed.ac.uk/iconics
- http://collections.ed.ac.uk/towardsdolly

Docker
------
There are a few steps needed in order to run Skylight on Docker. It is possible
to do this differently, using [Git submodules](https://git-scm.com/book/en/v2/Git-Tools-Submodules)
, however I don't really know how and can't be bothered.

So instead you need to clone the two repos and set up the following directory structure.

Cd into ./skylight-local/ and `cp Docker/Dockerfile ../`

```
.
├── Dockerfile
├── skylight
│   ├── application
│   ├── assets
│   ├── system
│   └── theme
└── skylight-local
    ├── config
    ├── docker
    ├── static
    ├── theme
    └── theme-local
```

From the root directory you can build the skylight container:
`docker build . -t "skylight"` (this container is [tagged](https://docs.docker.com/engine/reference/commandline/build/#tag-an-image--t) as "skylight")

To run the container you enter this Docker run command.

``docker run --name skylight_eerc -it -p 8080:80 -v `pwd`/skylight:/var/html/www/skylight -v `pwd`/skylight-local:/var/html/www/skylight-local skylight``
 
 `-name skylight_eerc` : name the container for future reference 
 
 `-p 8080:80` : links host port 8080 to port 80 in the container (meaning http://localhost:8080 will direct to the container)
  
 `-v [HOST-PATH]:[CONTAINER-PATH]` a volume, linking a host directory into a container directory meaning you can edit php files
live on you computer which will change in the container as well (note that you might need to provide absolute paths for the volumes)

The final step is to do port forwarding inside the container:

`docker exec -it skylight_eercs bash`

and then

`ssh -4 -N -f -L 9122:127.0.0.1:8080 dspace@lac-repo-test14.is.ed.ac.uk`

and possibly

`ssh -4 -N -f -L 9123:127.0.0.1:8090 dspace@lac-repo-test14.is.ed.ac.uk`

(this step could probably be automated in some neat way, for instance by having SSL
 key file to authenticate to the server but again, too lazy)

