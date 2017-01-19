<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                version="1.0">
<xsl:output indent="yes" method="html"/>
<xsl:template match="/">
    <html>
         <head></head>
         <body>
             <h1><a href="welcome.php"><xsl:value-of select="//homeButton"/></a></h1>
             <xsl:apply-templates select="//image"/>
             <p><xsl:apply-templates select="//likes"/></p>
             <xsl:if test="//isOwner">
                 <form method="post" action="post.php?id={//postID}">
                     <input type="submit" value="Like" name="like"/>
                 </form>
             </xsl:if>
             <p><xsl:apply-templates select="//dislikes"/></p>
             <xsl:if test="//isOwner">
                 <form method="post" action="post.php?id={//postID}">
                     <input type="submit" value="Dislike" name="dislike"/>
                 </form>
             </xsl:if>
             <p><xsl:apply-templates select="//comments"/></p>
        </body>
    </html>
</xsl:template>

<xsl:template match="image">
    <img src="data:image/jpeg;base64,{.}"/>
</xsl:template>

<xsl:template match="likes">
    <xsl:value-of select="text"/>: <xsl:value-of select="value"/>
</xsl:template>

<xsl:template match="dislikes">
    <xsl:value-of select="text"/>: <xsl:value-of select="value"/>
</xsl:template>

<xsl:template match="comments">
    <xsl:for-each select="comment">
        <a href="user.php?username={user}"><xsl:value-of select="user"/></a>: <xsl:value-of select="value"/>
        <br/>
    </xsl:for-each>
</xsl:template>

</xsl:stylesheet>
