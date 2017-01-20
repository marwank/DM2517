<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:output indent="yes" method="html"/>
    <xsl:template match="/">
        <html>
            <head></head>
            <body>
                <h1><a href="welcome.php"><xsl:value-of select="//homeButton"/></a></h1>
                <form method="get" action="post.php">
                    <input type="hidden" name="id" value="{//postID}"/>
                    <input type="hidden" name="lang" value="{//changeLang}"/>
                    <input type="image" height="40px" width="40px" src="{//langFlag}" alt="{//changeLang}"/>
                    <input type="submit" value="{//inLang}"/>
                </form>
            <xsl:apply-templates select="//image"/>
            <p>
                <xsl:apply-templates select="//description"/>
                <xsl:if test="//isOwner">
                    <form method="post" action="post.php?id={//postID}">
                        <input type="text" accept="text/plain" name="{//editDescription}"/>
                        <input type="submit" value="{//editDesc}"/>
                    </form>
                </xsl:if>
            </p>
            <p>
                <xsl:apply-templates select="//likes"/>
                <xsl:if test="//user">
                    <form method="post" action="post.php?id={//postID}">
                        <input type="hidden" name="like"/>
                        <input type="image" src="like.png" width="20px" height="20px" alt="Like"/>
                    </form>
                </xsl:if>
            </p>
            <p>
                <xsl:apply-templates select="//dislikes"/>
                <xsl:if test="//user">
                    <form method="post" action="post.php?id={//postID}">
                        <input type="hidden" name="dislike"/>
                        <input type="image" src="dislike.png" width="20px" height="20px" alt="Dislike"/>
                    </form>
                </xsl:if>
            </p>
            <xsl:if test="//isOwner">
                <p>
                    <form method="post" action="post.php?id={//postID}">
                        <input type="text" accept="text/plain" name="addTag"/>
                        <input type="submit" value="{//addTag}" />
                    </form>
                    <xsl:apply-templates select="//tags"/>
                </p>
            </xsl:if>
            <p>
                <xsl:if test="//user">
                    <form method="post" action="post.php?id={//postID}">
                        <input type="text" accept="text/plain" name="addComment"/>
                        <input type="submit" value="{//addComment}" />
                    </form>
                </xsl:if>
            </p>
            <p><xsl:apply-templates select="//comments"/></p>
        </body>
    </html>
</xsl:template>

<xsl:template match="image">
    <img src="data:image/jpeg;base64,{.}"/>
</xsl:template>

<xsl:template match="description">
    <xsl:value-of select="."/>
</xsl:template>

<xsl:template match="likes">
    <xsl:value-of select="text"/>: <xsl:value-of select="value"/>
</xsl:template>

<xsl:template match="dislikes">
    <xsl:value-of select="text"/>: <xsl:value-of select="value"/>
</xsl:template>

<xsl:template match="tags">
    <xsl:for-each select="tag">
        <xsl:value-of select="."/>
        <form method="post" action="post.php?id={//postID}">
            <input type="hidden" name="removeTag" value="{.}"/>
            <input type="image" width="15px" height="15px" src="minus.jpg" alt="-"/>
        </form>
    </xsl:for-each>
</xsl:template>

<xsl:template match="comments">
    <xsl:for-each select="comment">
        <a href="user.php?username={username}"><xsl:value-of select="username"/></a>: <xsl:value-of select="value"/>
        <xsl:if test="removeComment">
            <form method="post" action="post.php?id={//postID}">
                <input type="hidden" name="removeComment" value="{commentID}"/>
                <input type="image" width="15px" height="15px" src="minus.jpg" alt="-"/>
            </form>
        </xsl:if>
        <br/>
    </xsl:for-each>
</xsl:template>

</xsl:stylesheet>
