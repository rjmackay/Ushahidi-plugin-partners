=== About ===
name: Partner Reports
website: http://www.uchaguzi.co.ke
description: Ties reports to partner roles
version: 0.1
requires: 2.5
tested up to: 2.5
author: Robbie Mackay
author website: http://www.robbiemackay.com

== Description ==
Groups reports based on partners. Partners are based on a selected group of roles.

A report is assigned to a particular partner based on which user created it or
the reporter for the message it was created from.

Users with a partner role will see just the reports created by users with that role.
Admin users can see all reports, and filter based on partner.
Users on the frontend reports listing can filter reports based on partner.

Additional reports listing pages are added which pre filter based on partner, urls
for these are like reports/partners/index/ID. These pages are not added to the menu
automatically.

== Installation ==
1. Copy the entire /partner/ directory into your /plugins/ directory.
2. Activate the plugin.
3. Go to /admin/manage/partners and select roles to treat as partners

== Changelog ==
