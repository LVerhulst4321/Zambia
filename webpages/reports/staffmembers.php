<?php
// Copyright (c) 2018 Peter Olszowka. All rights reserved. See copyright document for more details.
$report = [];
$report['name'] = 'Staff Members';
$report['description'] = 'List Staff Members and their priviliges';
$report['categories'] = array(
    'Zambia Administration Reports' => 1010,
);
$report['queries'] = [];
$report['queries']['staff'] =<<<'EOD'
SELECT
        badgeid,
        if(P.pubsname is null or P.pubsname = '',concat(CD.firstname,' ',CD.lastname),P.pubsname) as name,
        if (P.password='4cb9c8a8048fd02294477fcb1a41191a','changme','OK') as password
    FROM
             Participants P
        JOIN CongoDump CD using (badgeid)
    WHERE
        P.badgeid in (SELECT badgeid FROM UserHasPermissionRole WHERE permroleid = 2) ##staff
    ORDER BY
        CD.lastname, CD.firstname;
EOD;
$report['queries']['privileges'] =<<<'EOD'
SELECT
        UHPR.badgeid,
        PR.permrolename
    FROM
             UserHasPermissionRole UHPR
        JOIN PermissionRoles PR using (permroleid)
    WHERE
		UHPR.badgeid in (SELECT badgeid FROM UserHasPermissionRole WHERE permroleid = 2);
EOD;
$report['xsl'] =<<<'EOD'
<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.1" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output encoding="UTF-8" indent="yes" method="html" />
    <xsl:include href="xsl/reportInclude.xsl" />
    <xsl:template match="/">
        <xsl:choose>
            <xsl:when test="doc/query[@queryName='staff']/row">
                <table class="report">
                    <tr>
                        <th class="report">Badgeid</th>
                        <th class="report">Name</th>
                        <th class="report">Password</th>
                        <th class="report">Permission roles</th>
                    </tr>
                    <xsl:apply-templates select="doc/query[@queryName='staff']/row"/>
                </table>
            </xsl:when>
            <xsl:otherwise>
                <div class="alert alert-danger">No results found.</div>
            </xsl:otherwise>                    
        </xsl:choose>
    </xsl:template>

    <xsl:template match="doc/query[@queryName='staff']/row">
        <xsl:variable name="badgeid" select="@badgeid" />
        <tr>
            <td class="report"><xsl:call-template name="showBadgeid"><xsl:with-param name="badgeid" select="@badgeid"/></xsl:call-template></td>
            <td class="report"><xsl:value-of select="@name"/></td>
            <td class="report"><xsl:value-of select="@password"/></td>
            <td class="report">
                <xsl:apply-templates select="/doc/query[@queryName = 'privileges']/row[@badgeid = $badgeid]"/>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="/doc/query[@queryName='privileges']/row">
        <div><xsl:value-of select="@permrolename"/></div>
    </xsl:template>
</xsl:stylesheet>
EOD;
