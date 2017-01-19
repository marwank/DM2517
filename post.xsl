<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                version="1.0">
<xsl:output indent="yes" method="html"/>
<xsl:template match="/">
   <html>
     <head></head>
     <body>
      <xsl:apply-templates select="//image"/>
      <p>
          <xsl:apply-templates select="//likes"/>
          <br/>
          <xsl:apply-templates select="//dislikes"/>
      </p>
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

</xsl:stylesheet>
