package com.sshilko.cources.java8;

import org.junit.jupiter.api.Assertions;

import java.io.IOException;
import java.net.URI;
import java.net.URISyntaxException;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.time.Duration;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

import org.junit.jupiter.api.AfterAll;
import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Disabled;
import org.junit.jupiter.api.Tag;

import org.junit.jupiter.api.Test;

/**
 * Unit test for simple App.
 * 
 * @see https://howtodoinjava.com/junit-5-tutorial/
 * @see https://howtodoinjava.com/
 */
public class AppTest {
    /**
     * Rigorous Test :-)
     * 
     * @throws URISyntaxException
     */
    @Test
    public void shouldAnswerWithTrue() throws URISyntaxException {
        /**
         * Java 11 tests
         * 
         * @see https://howtodoinjava.com/java11/
         */
        var demoString = "hello\nworld";
        var textLines = new ArrayList<>();
        demoString.lines().forEach(line -> textLines.add(line));
        Assertions.assertEquals(List.of("hello", "world"), textLines);

        String iamnull = null;
        String emptystr = "";

        Assertions.assertTrue(emptystr.isBlank());
        Assertions.assertTrue(Optional.ofNullable(iamnull).isEmpty());
        Assertions.assertFalse(Optional.ofNullable(iamnull).isPresent());

        var somestring = "hello ";
        Assertions.assertEquals(somestring.trim(), "hello");

        /**
         * Java 10 tests
         * 
         * @see https://howtodoinjava.com/java10/java10-features/
         */
        var listCopy = List.copyOf(textLines);
        Assertions.assertEquals(textLines, listCopy);

        /**
         * Java 9 -> Java 11 tests
         * @see https://www.baeldung.com/java-9-http-client
         */
        var URI = new URI("https://howtodoinjava.com");
        HttpClient httpClient = HttpClient.newHttpClient();
        HttpRequest httpRequest = HttpRequest.newBuilder().uri(URI).version(HttpClient.Version.HTTP_2)
                .timeout(Duration.ofSeconds(2)).GET().build();

        HttpResponse<String> httpResponse;
        try {
            System.out.println("HTTP API A");
            httpResponse = httpClient.send(httpRequest, HttpResponse.BodyHandlers.ofString());
            System.out.println("HTTP API B");
            var responseCode = httpResponse.statusCode();
            System.out.println("HTTP API C");
            Assertions.assertEquals(200, responseCode);      
            System.out.println("HTTP API OK");
        } catch (IOException e) {
            e.printStackTrace();
            System.out.println("HTTP API ERROR 1");
        } catch (InterruptedException e) {
            e.printStackTrace();
            System.out.println("HTTP API ERROR 2");
        }

        Assertions.assertTrue( true );

        /**
         * Java 8 streams
         * https://howtodoinjava.com/java8/java-streams-by-examples/
         */

         /**
          * Reactive streams
          * https://www.reactive-streams.org/
          */
    }

    @BeforeAll
    static void setup(){
        System.out.println("@BeforeAll executed");
    }
     
    @BeforeEach
    void setupThis(){
        System.out.println("@BeforeEach executed");
    }
     
    @Tag("DEV")
    @Test
    void testCalcOne() 
    {
        System.out.println("======TEST ONE EXECUTED=======");
        Assertions.assertEquals( 4 , 2 + 2);
    }
     
    @Tag("PROD")
    @Disabled
    @Test
    void testCalcTwo() 
    {
        System.out.println("======TEST TWO EXECUTED=======");
        Assertions.assertEquals( 6 , 2 + 4);
    }
     
    @AfterEach
    void tearThis(){
        System.out.println("@AfterEach executed");
    }
     
    @AfterAll
    static void tear(){
        System.out.println("@AfterAll executed");
    }    
}
