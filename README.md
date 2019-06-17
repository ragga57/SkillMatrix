Skill Matrix
==============================

Plugin for monitoring knowledge of existing users

Author
------

- Jan Válka
- License MIT

Requirements
------------

- Kanboard >= 1.0.35

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/SkillMatrix`
3. Clone this repository into the folder `plugins/SkillMatrix`

Note: Plugin folder is case-sensitive.

Documentation
-------------

Plugin Skill Matrix gives you the option to monitor knowledge of existing users.
Setup is as follows:
1. Create skills and tags
2. Assign skill values and tags to different users
3. Done

Now you can use these atributes to search for users that meet your requirements.

Search syntax is `atribute:value` and spaces act as logic AND
Few examples:
```
skill:skill1>2
skill:skill2>=2 skill:skill5>2
skill:skill3>3 tag:tag1 tag:tag2
```
More detailed documentation can be found [here](https://github.com/ragga57/BP/blob/master/xvalka03.pdf)