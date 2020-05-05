Docker
------
Using docker for development is very convenient because it allows proper sandboxing. You can break stuff!

This is done in a live realtime environment meaning you don't need to rebuild/redeploy. 

First off you need to clone both Skylight repos.

Cd into their shared parent direcotry ../ and do one of either:
* `cp skylight-local-docker/Dockerfile .` for PHP5
* `cp skylight-local-docker/Dockerfile-php7 ./Dockerfile` for PHP7
resulting in this structure:

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

When building a docker image the instructions need to reside in a file called `Dockerfile`. The reason I copy the
Dockerfile into their parent file is so that both skylight and skylight-local files can be edited in realtime.
Note that when docker builds an image it will appropriate all the files in the directory and it's subdirectories,
if there are many other sibling directories to `skylight` and `skylight-local` it will result in a big so-called
build context, this can be avoided by either copying the repos to a subdirectory and building there or adding a
`.dockerignore` file that lists the unnecessary directories.
(see [Dockerfile reference](https://docs.docker.com/engine/reference/builder/))
It is possible to do this differently, using [Git submodules](https://git-scm.com/book/en/v2/Git-Tools-Submodules)
, however I don't really know how and can't be bothered.

### Build an image ###

From the root directory you can build the skylight image:
`docker build . -t "[container_name]"` (this container is
[tagged](https://docs.docker.com/engine/reference/commandline/build/#tag-an-image--t) as "[container_name]")
Don't worry if you see some errors or warnings, that's just Ubuntu moaning about unimportant stuff.

To run (or create) a container (a container is an instance of an image) you enter this Docker run command.

``docker run --name [container_name] -it -p 8080:80 -v `pwd`/skylight:/var/html/www/skylight -v
 `pwd`/skylight-local:/var/html/www/skylight-local skylight``
 
 `-name [container_name] ` : name the container for future reference, for instance skylight_eerc 
 
 `-p 8080:80` : links host port 8080 to port 80 in the container (meaning http://localhost:8080 will direct
  to the container)
  
 `-v [HOST-PATH]:[CONTAINER-PATH]` a volume, linking a host directory into a container directory meaning you
  can edit php files live on your computer which will change in the container as well (note that you might
  need to provide absolute paths for the volumes)


### Start/stop container ###

The containers are configured to run apache as their main job. To start the container: `docker start [container_name]`
simple as (you can add the parameter `-d` to run in detached mode this means that the stdout from the container
won't be visible). If you run the container in attached mode the CTRL+C will stop it. If you run it in detached
mode `docker ps` will tell you what containers are currently running (parameter `-a` to list all containers) and
`docker stop [container_name]` to stop it.

### Messing around inside ###

I've chosen Ubuntu as the OS because it's my OS of choice. Could be CentOS if we wanted to replicate the vms but
it shouldn't matter. You can enter the running container by doing:

`docker exec -it [container_name] bash`

just type `exit` to exit the container, doing so will not stop the container, only exit from it back onto your
machine. 

The final step is to do port forwarding inside the container and then to redirect internal calls to
`localhost:[port]`, in this case 9122, to lac-repo-test14.is.ed.ac.uk. This is to accommodate for whatever
has been defined as `$config['skylight_solrbase']`.

`ssh -4 -N -f -L 9130:127.0.0.1:8080 dspace@lac-repo-test14.is.ed.ac.uk`

or

`ssh -4 -N -f -L 9122:127.0.0.1:8080 dspace@lac-repo-test14.is.ed.ac.uk`

and possibly if ArchivesSpace is being used

`ssh -4 -N -f -L 9123:127.0.0.1:8090 dspace@lac-repo-test14.is.ed.ac.uk`

repeat `ssh -4 -N -f -L [portnumber]:127.0.0.1:8080 dspace@lac-repo-test14.is.ed.ac.uk` as necessary

(this step could probably be automated in some neat way, for instance by having SSL
key file to authenticate to the server but again, too lazy)

By now you've created an image and a container instance of that image. The creation of the volumes
ensures that content in the skylight folders can be edited in realtime and doesn't require the container
to be rebuilt or restarted.

