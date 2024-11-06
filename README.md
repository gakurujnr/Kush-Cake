
1.	Configure 
a.	  git config --global user.email "you@example.com"
b.	  git config --global user.name "Your Name"
2.	Initialize
a.	git init
3.	Stage
a.	git status
b.	git add . OR git add {filename} (means add every modification to staging area)
c.	incase you want to remove a staged file from staging area use this cmd: git rm –cached {Filename}
4.	Commit  with a message on modification---remember we only commit at logical points. Commit messages should be descriptive for future references.
a.	git commit -m “this is my first commit”
b.	checkout commit(shows the code at this point in time), revert commit(deletes the changes an sends the code back to the last point of commit), reset commit(permanently deletes the modifications)
i.	git checkout {git id }  to get the id use (git log –oneline)
ii.	to go back to the last point of commit .. git checkout master
5.	Check Status
a.	git status
b.	git log  (This cmd shows a history of all the commits we have done)
c.	git log –oneline (This cmd shows a summary of the history of all the commits we have done)
6.	checkout your branches
a.	git branch -a
7.	pick the branch to post on 
a.	git checkout milestone
