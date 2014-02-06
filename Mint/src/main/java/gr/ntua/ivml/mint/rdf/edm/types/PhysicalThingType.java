//
// This file was generated by the JavaTM Architecture for XML Binding(JAXB) Reference Implementation, vJAXB 2.1.10 in JDK 6 
// See <a href="http://java.sun.com/xml/jaxb">http://java.sun.com/xml/jaxb</a> 
// Any modifications to this file will be lost upon recompilation of the source schema. 
// Generated on: 2011.05.04 at 01:49:42 PM EEST 
//


package gr.ntua.ivml.mint.rdf.edm.types;

import java.util.ArrayList;
import java.util.List;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlSchemaType;
import javax.xml.bind.annotation.XmlType;


/**
 * A persistent physical item such as a painting, a building, a book or a stone.
 * Persons are not items. This class represents Cultural Heritage Objects known
 * to Europeana to be physical things (such as Mona Lisa) as well as all physical
 * things Europeana refers to in the descriptions of Cultural Heritage Objects
 * (such as the Rosetta Stone).
 * 
 * Example:the Venus by Praxiteles,any non-digital Cultural Heritage Object, the House of Parliament
 * 			
 * 
 * <p>Java class for PhysicalThingType complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="PhysicalThingType">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="identifier" type="{http://www.example.org/EDMSchemaV9}Resource"/>
 *         &lt;element name="type" type="{http://www.example.org/EDMSchemaV9}SimpleLiteral" minOccurs="0"/>
 *         &lt;element name="realizes" type="{http://www.w3.org/2001/XMLSchema}anyURI" maxOccurs="unbounded" minOccurs="0"/>
 *         &lt;element name="currentLocation" type="{http://www.example.org/EDMSchemaV9}PlaceType" maxOccurs="unbounded" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "PhysicalThingType", propOrder = {
    "identifier",
    "type",
    "realizes",
    "currentLocation"
})
public class PhysicalThingType {

    @XmlElement(required = true)
    protected Resource identifier;
    protected SimpleLiteral type;
    @XmlSchemaType(name = "anyURI")
    protected List<String> realizes;
    protected List<PlaceType> currentLocation;

    /**
     * Gets the value of the identifier property.
     * 
     * @return
     *     possible object is
     *     {@link Resource }
     *     
     */
    public Resource getIdentifier() {
        return identifier;
    }

    /**
     * Sets the value of the identifier property.
     * 
     * @param value
     *     allowed object is
     *     {@link Resource }
     *     
     */
    public void setIdentifier(Resource value) {
        this.identifier = value;
    }

    /**
     * Gets the value of the type property.
     * 
     * @return
     *     possible object is
     *     {@link SimpleLiteral }
     *     
     */
    public SimpleLiteral getType() {
        return type;
    }

    /**
     * Sets the value of the type property.
     * 
     * @param value
     *     allowed object is
     *     {@link SimpleLiteral }
     *     
     */
    public void setType(SimpleLiteral value) {
        this.type = value;
    }

    /**
     * Gets the value of the realizes property.
     * 
     * <p>
     * This accessor method returns a reference to the live list,
     * not a snapshot. Therefore any modification you make to the
     * returned list will be present inside the JAXB object.
     * This is why there is not a <CODE>set</CODE> method for the realizes property.
     * 
     * <p>
     * For example, to add a new item, do as follows:
     * <pre>
     *    getRealizes().add(newItem);
     * </pre>
     * 
     * 
     * <p>
     * Objects of the following type(s) are allowed in the list
     * {@link String }
     * 
     * 
     */
    public List<String> getRealizes() {
        if (realizes == null) {
            realizes = new ArrayList<String>();
        }
        return this.realizes;
    }

    /**
     * Gets the value of the currentLocation property.
     * 
     * <p>
     * This accessor method returns a reference to the live list,
     * not a snapshot. Therefore any modification you make to the
     * returned list will be present inside the JAXB object.
     * This is why there is not a <CODE>set</CODE> method for the currentLocation property.
     * 
     * <p>
     * For example, to add a new item, do as follows:
     * <pre>
     *    getCurrentLocation().add(newItem);
     * </pre>
     * 
     * 
     * <p>
     * Objects of the following type(s) are allowed in the list
     * {@link PlaceType }
     * 
     * 
     */
    public List<PlaceType> getCurrentLocation() {
        if (currentLocation == null) {
            currentLocation = new ArrayList<PlaceType>();
        }
        return this.currentLocation;
    }

}